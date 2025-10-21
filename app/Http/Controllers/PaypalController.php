<?php

namespace App\Http\Controllers;

use App\Models\EmailPayment;
use App\Models\PartsPayment;
use App\Models\TexturesPayment;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use App\Mail\CartMail;
use App\Models\Location;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaypalController extends Controller
{

    public function updateStatus(Request $request, $id)
    {
        // الحالات المسموح بها فقط
        $validStatuses = ['processing', 'on_the_way', 'delivered', 'cancelled'];

        // التحقق من الإدخال
        $request->validate([
            'status' => 'required|string|in:' . implode(',', $validStatuses),
        ]);

        // البحث عن عملية الدفع
        $payment = Payment::findOrFail($id);
        $payment->status = $request->status;
        $payment->save();

        return response()->json([
            'message' => 'تم تحديث حالة الطلب بنجاح',
            'payment' => $payment,
            'success' => 200
        ], 200);
    }


    /**
     * Create PayPal Order
     */
    public function paypal(Request $request)
    {
        try {
            $request->validate([
                'total' => 'required|numeric|min:0',
                'shipping_price' => 'required|numeric|min:0',
                'items' => 'required|array|min:1',
                'user.id' => 'required|integer',
                'location' => 'required|array'
            ]);

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $total = $request->total + $request->shipping_price;

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('success'),
                    "cancel_url" => route('cancel'),
                ],
                "purchase_units" => [[
                    "amount" => [
                        "currency_code" => "EUR",
                        "value" => number_format($total, 2, '.', '')
                    ]
                ]]
            ]);

            if (!isset($response['id'])) {
                Log::error('PayPal order creation failed', ['response' => $response]);
                return response()->json(['success' => false, 'message' => 'Failed to create PayPal order.'], 500);
            }

            // Save session data
            session()->put('payment_data', [
                'items' => $request->items,
                'user' => $request->user,
                'shipping_price' => $request->shipping_price,
                'total' => $total,
                'location' => $request->location,
                'order_id' => $response['id'],
            ]);

            $approvalLink = collect($response['links'])->firstWhere('rel', 'approve')['href'] ?? null;

            if ($approvalLink) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => $approvalLink,
                ]);
            }

            Log::warning('PayPal approval link not found', ['response' => $response]);
            return response()->json(['success' => false, 'message' => 'Approval link not found.'], 500);
        } catch (Exception $e) {
            Log::error('PayPal Order Error', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Something went wrong during payment initialization.'], 500);
        }
    }

    /**
     * Handle successful PayPal capture
     */
    public function success(Request $request)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $response = $provider->capturePaymentOrder($request->token);

            if (!isset($response['status']) || $response['status'] !== 'COMPLETED') {
                Log::warning('PayPal payment not completed', ['response' => $response]);
                return redirect()->route('cancel')->with('error', 'Payment not completed.');
            }

            $paymentData = session()->get('payment_data');
            if (!$paymentData) {
                Log::error('Missing payment session data after PayPal success');
                return redirect()->route('cancel')->with('error', 'Payment data missing.');
            }

            $vatRate = 19;
            $cartItems = $paymentData['items'];
            $shippingPrice = $paymentData['shipping_price'];

            $totalWithVat = 0;
            $totalVat = 0;

            foreach ($cartItems as &$item) {
                $itemVat = ($item['price'] * $vatRate / 100) * $item['quantity'];
                $totalVat += $itemVat;
                $totalWithVat += ($item['price'] * $item['quantity']);
                $item['vat'] = $itemVat;
            }

            $totalWithoutVat = $totalWithVat - $totalVat;
            $total = $totalWithVat + $shippingPrice;

            $paymentInfo = [
                'total_with_vat' => $totalWithVat,
                'total_vat' => $totalVat,
                'total_without_vat' => $totalWithoutVat,
                'shipping_price' => $shippingPrice,
                'total' => $total,
                'payment_method' => 'paypal',
                'payment_id' => $response['id'],
            ];

            // Save payments
            foreach ($cartItems as $item) {
                $payment = Payment::create([
                    'payment_id' => $response['id'],
                    'user_id' => $paymentData['user']['id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'currency' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? 'EUR',
                    'payer_name' => $paymentData['location']['first_name'].' '.$paymentData['location']['last_name'],
                    'payer_email' => $response['payer']['email_address'] ?? null,
                    'country' => $paymentData['location']['country'] ?? '',
                    'street' => $paymentData['location']['street'] ?? '',
                    'house_number' => $paymentData['location']['house_number'] ?? '',
                    'zipcode' => $paymentData['location']['zipcode'] ?? '',
                    'phone' => $paymentData['location']['phone'] ?? '',
                    'shipping_price' => $shippingPrice,
                    'vat' => $item['vat'] ?? 0,
                    'amount' => $item['price'],
                    'total' => number_format($item['price'] * $item['quantity'], 2),
                    'payment_status' => 'Completed',
                    'payment_method' => 'paypal',
                ]);

                // Save parts and textures
                foreach ($item['partsBreakdown'] ?? [] as $part) {
                    PartsPayment::create([
                        'email_payment_id' => $payment->id,
                        'name' => $part['name'],
                        'price' => $part['price'],
                    ]);
                }
                foreach ($item['texturesBreakdown'] ?? [] as $texture) {
                    TexturesPayment::create([
                        'email_payment_id' => $payment->id,
                        'name' => $texture['name'],
                        'price' => $texture['price'],
                    ]);
                }
            }

            // Save location if new
            if (empty($paymentData['location']['location_id'])) {
                Location::create([
                    'user_id' => $paymentData['user']['id'],
		'first_name' => $paymentData['location']['first_name'],
		'last_name' => $paymentData['location']['last_name'],
                    'country' => $paymentData['location']['country'],
                    'street' => $paymentData['location']['street'],
                    'house_number' => $paymentData['location']['house_number'],
                    'zip_code' => $paymentData['location']['zipcode'],
                    'phone' => $paymentData['location']['phone'],
                ]);
            }

            // Send mail
            try {
                Mail::to($paymentData['user']['email'])->send(
                    new CartMail($cartItems, $paymentData['user']['email'], $paymentInfo, $paymentData['location'])
                );
            } catch (Exception $mailError) {
                Log::error('Mail sending failed', ['error' => $mailError->getMessage()]);
            }

            session()->forget('payment_data');
            session()->put('success', 'Payment completed successfully.');
            return redirect()->route('payment_paypal.success', ['payment_id' => $response['id']]);

        } catch (Exception $e) {
            Log::error('PayPal success error', ['error' => $e->getMessage()]);
            return redirect()->route('cancel')->with('error', 'Something went wrong during payment processing.');
        }
    }


//     public function paypal(Request $request)
//     {
//         // dd($request->all());
//         $provider = new PayPalClient;
//         $provider->setApiCredentials(config('paypal'));
//         $paypalToken = $provider->getAccessToken();

//         // المجموع الكلي مع سعر الشحن
//         $total = $request->total + $request->shipping_price;

//         $response = $provider->createOrder([
//             "intent" => "CAPTURE",
//             "application_context" => [
//                 "return_url" => route('success'),
//                 "cancel_url" => route('cancel')
//             ],
//             "purchase_units" => [
//                 [
//                     "amount" => [
//                         "currency_code" => "EUR",
//                         "value" => $total
//                     ]
//                 ]
//             ]
//         ]);
//         // dd($response );
//         if (isset($response['id']) && $response['id'] != null) {
//             foreach ($response['links'] as $link) {
//                 if ($link['rel'] === 'approve') {
//                     session()->forget('payment_data');
//                     session()->put('payment_data', [
//                         'items' => $request->items,
//                         'user' => $request->user,
//                         'shipping_price' => $request->shipping_price,
//                         'total' => $total,
//                         'location' => $request->location,
//                         'order_id' => $response['id']
//                     ]);

//                     return response()->json([
//                         'success' => true,
//                         'redirect_url' => $link['href']
//                     ]);
//                 }
//             }
//         } else {
//             return redirect()->route('cancel');
//         }
//     }
//     public function success(Request $request)
//     {
//         $provider = new PayPalClient;
//         $provider->setApiCredentials(config('paypal'));
//         $paypalToken = $provider->getAccessToken();
//         $response = $provider->capturePaymentOrder($request->token);
    
//         if (isset($response['status']) && $response['status'] == 'COMPLETED') {
//             $paymentData = session()->get('payment_data');
    
//             // نسبة الضريبة
//             $vatRate = 19; // نسبة الضريبة 19%
    
//             // القيم الإجمالية
//             $totalPriceWithVat = 0;
//             $totalVat = 0;
//             $totalPriceWithoutVat = 0;
//             $totalShippingVat = 0;
    
//             $cartItems = $paymentData['items'];
//             $store_data2 = $paymentData['items'];
    
//             foreach ($cartItems as &$item) { // استخدم مرجع العنصر (&$item)
//                 // قيمة الضريبة على المنتج للقطعة الواحدة
//                 $vatAmount = ($item['price'] * $vatRate) / 100;
//                 // سعر المنتج بدون ضريبة
//                 $prodPrice = $item['price'] - $vatAmount;
//                 // الضريبة للقطعة الكلية
//                 $vatItem = $vatAmount * $item['quantity'];
                
//                 // حساب ضريبة الشحن
//                 $shippingVat = ($item['shipping_price'] * $vatRate) / 100;
//                 // إضافة الضريبة الكلية للشحن
//                 $totalShippingVat += $shippingVat;
        
//                 // تحديث المصفوفة
//                 $item['vatAmount'] = $vatAmount;
//                 $item['prodPrice'] = $prodPrice;
//                 $item['vatItem'] = $vatItem + $shippingVat; // إضافة الضريبة على الشحن
                
//                 // جمع القيم الإجمالية
//                 $totalPriceWithVat += $item['price'] * $item['quantity'];
//                 $totalVat += $vatItem + $shippingVat; // الضريبة الكلية تشمل المنتج والشحن
                
//             }
    
//             // إجمالي الشحن
//             $shipping_price = $paymentData['shipping_price'];
    
//             // بيانات الدفع الإجمالية
//             $total_data = [
//                 'totalPriceWithVat' => $totalPriceWithVat,
//                 'totalVat' => $totalVat, // الضريبة تشمل المنتج + الشحن
//                 'totalPriceWithoutVat' => $totalPriceWithVat + $shipping_price -$totalVat ,
//                 'payment_method' => 'paypal',
//                 'user' => $paymentData['user'],
//                 'payment_id' => $response['id'],
//                 'shipping_price' => $shipping_price, // سعر الشحن
//                 'total' => $totalPriceWithVat + $shipping_price, // السعر الإجمالي شامل الشحن والضريبة
//             ];
    
//             // بيانات الموقع والمستخدم
//             $location_data = $paymentData['location'];
//             $customerEmail = $paymentData['user']['email'];
//             $ownerEmail = $paymentData['user']['email'];
    
//             // إرسال البريد الإلكتروني
//             Mail::to($ownerEmail)->send(new CartMail($cartItems, $customerEmail, $total_data, $location_data));
    
//             // تخزين بيانات الدفع في قاعدة البيانات
//             foreach ($store_data2 as $item) {
//                 $payment = new Payment();
//                 $payment->payment_id = $response['id'];
//                 $payment->user_id = $paymentData['user']['id'];
//                 $payment->product_name = $item['name'];
//                 $payment->quantity = $item['quantity'];
//                 $payment->currency = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'];
//                 $payment->payer_name = $location_data['fname']. ' ' . $location_data['lname'];
//                 $payment->payer_email = $response['payer']['email_address'];
//                 $payment->country = $paymentData['location']['country'];
//                 $payment->street = $paymentData['location']['street'];
//                 $payment->address = $paymentData['location']['address'];
//                 $payment->zipcode = $paymentData['location']['zipcode'];
//                 $payment->location = $paymentData['location']['location'];
//                 $payment->phone = $paymentData['location']['phone'];
//                 $payment->shipping_price = $item['shipping_price'];
    
//                 // الضريبة على المنتج
//                 $payment->vat = ($item['price'] * $vatRate) / 100;
//                 $payment->amount = $item['price'];
//                 $payment->total = number_format(($item['quantity'] * $item['price']) + ($item['shipping_price'] ?? 0), 2);
    
//                 $payment->payment_status = 'Completed';
//                 $payment->payment_method = 'paypal';
//                 $payment->save();
    
//                 // تخزين بيانات الأجزاء
//                 if (!empty($item['partsBreakdown'])) {
//                     foreach ($item['partsBreakdown'] as $part) {
//                         PartsPayment::create([
//                             'email_payment_id' => $payment->id,
//                             'name' => $part['name'],
//                             'price' => $part['price'],
//                         ]);
//                     }
//                 }
    
//                 // تخزين بيانات الأقمشة
//                 if (!empty($item['texturesBreakdown'])) {
//                     foreach ($item['texturesBreakdown'] as $texture) {
//                         TexturesPayment::create([
//                             'email_payment_id' => $payment->id,
//                             'name' => $texture['name'],
//                             'price' => $texture['price'],
//                         ]);
//                     }
//                 }
//             }
    
//             // حفظ بيانات الموقع إذا لم يكن موجودًا
//             if (!isset($paymentData['location']['location_id']) || $paymentData['location']['location_id'] === null) {
//                 $location = new Location();
//                 $location->user_id = $paymentData['user']['id'];

//                   $location->first_name = $paymentData['location']['first_name'];
//                 $location->last_name = $paymentData['location']['last_name'];

//                 $location->country = $paymentData['location']['country'];
//                 $location->street = $paymentData['location']['street'];
//                 $location->address = $paymentData['location']['address'];
//                 $location->zip_code = $paymentData['location']['zipcode'];
//                 $location->location = $paymentData['location']['location'];
//                 $location->phone = $paymentData['location']['phone'];
//                 $location->save();
    
//                 // تحديث ID الموقع في الجلسة
//                 $paymentData['location']['location_id'] = $location->id;
//             }
    
//             session()->forget('payment_data');
//             session()->put('success', 'Payment was successful.');
//             return redirect()->route('payment_paypal.success', ['payment_id' => $response['id']]);
//         } else {
//             return redirect()->route('cancel');
//         }
//     }
    

    public function cartDetails($payment_id)
    {
        $payments = Payment::with(['user', 'parts', 'textures'])
            ->where('payment_id', $payment_id)
            ->get();
    
            $total_vat = 0;
            $total_amount = 0;
            $total_shipping_price = 0;
            $total_total = 0;
        
            foreach ($payments as $payment) {
                // الضريبة على المنتج مع الكمية
                $product_vat = $payment->vat * $payment->quantity;
        
                // الضريبة على سعر الشحن
                $shipping_vat = ($payment->shipping_price * 19) / 100; // نسبة الضريبة 19%
        
                // جمع ضريبة المنتج وضريبة الشحن
                $total_vat += $product_vat + $shipping_vat;
        
                // حساب إجمالي السعر بدون الضريبة
                $total_amount += ($payment->amount * $payment->quantity)+ $payment->shipping_price;
        
                // حساب إجمالي الشحن
                $total_shipping_price += $payment->shipping_price;
        
                // حساب المجموع الكلي
                $total_total += $payment->total;
            }
        
            // خصم إجمالي الضريبة من المبلغ الإجمالي بدون الضريبة
            $total_amount -= $total_vat;
        
        return view('payment.success', compact('payments', 'total_vat', 'total_amount', 'total_total', 'total_shipping_price'));
    }
    



    public function cancel()
    {
        return "Payment is cancelled.";
    }

    public function index()
    {
        $payments = Payment::all();
        return response()->json(['data' => $payments], 200);
    }

    // get user payments
    public function userPayments($id)
    {
        // جلب البيانات من الجدول الأول (Payment)
        $paypalpayments = Payment::where('user_id', $id)->get();

        // جلب البيانات من الجدول الثاني (EmailPayment)
        $emailPayments = EmailPayment::where('user_id', $id)->get();

        // دمج النتائج في متغير واحد
        $payments = $paypalpayments->merge($emailPayments);

        // إرجاع البيانات كـ JSON
        return response()->json(['data' => $payments], 200);
    }
}