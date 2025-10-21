<?php

namespace App\Http\Controllers;

use App\Models\EmailPayment;
use App\Models\TexturesPayment;
use App\Models\PartsPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CartMail;
use App\Models\Location;

use Illuminate\Support\Facades\DB;

class EmailPaymentController extends Controller
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
        $payment = EmailPayment::findOrFail($id);
        $payment->status = $request->status;
        $payment->save();

        return response()->json([
            'message' => 'تم تحديث حالة الطلب بنجاح',
            'payment' => $payment,
            'success' => 200
        ], 200);
    }
    public function sendCartDetails(Request $request)
    {
        // الحصول على بيانات الطلب
        $data = $request->all();
        // عناصر السلة لقاعدة البيانات
        $storeItems = $data['items'];
        // بيانات السلة
        $cartItems = $data['items'];
        $location_data = $data['location'];
        // المجموع مع سعر الضريبة
        $total = $data['total'] + $data['shipping_price'];
        // سعر التوصيل
        $shipping_price = $data['shipping_price'];
    
        // إنشاء رقم الطلب الفريد
        $latestInvoice = DB::table('email_payments')->latest('id')->first();
        $nextInvoiceNumber = $latestInvoice ? $latestInvoice->id + 1 : 1;
        $payment_id = 'aslanno' . $nextInvoiceNumber;
        // حساب الضريبة
        $vatRate = 19; // نسبة الضريبة
        $totalPriceWithVat = 0;
        $totalVat = 0;
        $totalPriceWithoutVat = 0;
        $totalShippingVat = 0; // متغير لتخزين ضريبة الشحن
    
        foreach ($cartItems as &$item) { // استخدم مرجع العنصر (&$item)
            // قيمة الضريبة للقطعة الواحدة
            $vatAmount = ($item['price'] * $vatRate) / 100;
            // سعر المنتج بدون ضريبة
            $prodPrice = $item['price'] - $vatAmount;
            // الضريبة للقطعة الكلية
            $vatItem = $vatAmount * $item['quantity'];
            
            // حساب ضريبة الشحن
            $shippingVat = ($item['shipping_price'] * $vatRate) / 100;
            // إضافة الضريبة الكلية للشحن
            $totalShippingVat += $shippingVat;
    
            // تحديث المصفوفة
            $item['vatAmount'] = $vatAmount;
            $item['prodPrice'] = $prodPrice;
            $item['vatItem'] = $vatItem + $shippingVat; // إضافة الضريبة على الشحن
            
            // جمع القيم الإجمالية
            $totalPriceWithVat += $item['price'] * $item['quantity'];
            $totalVat += $vatItem + $shippingVat; // الضريبة الكلية تشمل المنتج والشحن
            
        }
    
        // تخزين القيم في مصفوفة $total_data
        $total_data = [
            'totalPriceWithVat' => $totalPriceWithVat,
            'totalVat' => $totalVat,
            'totalPriceWithoutVat' => $totalPriceWithVat + $shipping_price -$totalVat ,
            'payment_method' => 'email',
            'user' => $data['user'],
            'payment_id' => $payment_id,
            'shipping_price' => $shipping_price, // سعر الشحن
            'total' => $totalPriceWithVat + $shipping_price, // السعر الإجمالي شامل الشحن والضريبة
        ];
    
        // البريد الإلكتروني الخاص بالعميل وصاحب المتجر
        $customerEmail = $data['user']['email'];
        $ownerEmail = $data['user']['email'];
    
        // إرسال البريد
        Mail::to($ownerEmail)->send(new CartMail($cartItems, $customerEmail, $total_data, $location_data));
    
        // إضافة بيانات الموقع إذا لم يكن لديه ID مسجل مسبقًا
        if (!isset($data['location']['location_id']) || $data['location']['location_id'] === null) {
            $location = new Location();
            $location->user_id = $data['user']['id'];

            $location->first_name = $data['location']['first_name'];
            $location->last_name = $data['location']['last_name'];

            $location->country = $data['location']['country'];
            $location->street = $data['location']['street'];
            $location->house_number = $data['location']['house_number'];
            $location->zip_code = $data['location']['zipcode'];
            $location->phone = $data['location']['phone'];
            $location->save();
    
            // بعد الحفظ، تحديث location_id في البيانات
            $data['location']['location_id'] = $location->id;
        }
    
        // إضافة بيانات الطلب إلى قاعدة البيانات
        foreach ($storeItems as $item) {
            $storage_data = new EmailPayment();
            $storage_data->payment_id = $payment_id;
            $storage_data->user_id = $data['user']['id'];
            $storage_data->product_name = $item['name'];
            $storage_data->quantity = $item['quantity'];
            $storage_data->currency = 'usd';
            $storage_data->payer_name = $data['location']['first_name'] . ' ' . $data['location']['last_name'];
            $storage_data->payer_email = $data['user']['email'];
            $storage_data->country = $data['location']['country'];
            $storage_data->street = $data['location']['street'];
            $storage_data->house_number = $data['location']['house_number'];
            $storage_data->zipcode = $data['location']['zipcode'];
            $storage_data->phone = $data['location']['phone'];
            $storage_data->shipping_price = $item['shipping_price']; // حفظ سعر الشحن
            // قيمة الضريبة للقطعة الواحدة
            $vatAmount = ($item['price'] * $vatRate) / 100;
            $storage_data->vat = $vatAmount; // تخزين قيمة الضريبة
            $storage_data->amount = $item['price'];
	//   price
	$price = (float) $item['price'];
            $storage_data->total = ($item['quantity'] * $price) + ($item['shipping_price'] ?? 0); // تخزين المبلغ الإجمالي
            $storage_data->payment_status = 'Pending';
            $storage_data->payment_method = 'email';
            $storage_data->save();
    
            // إضافة بيانات parts إذا كانت موجودة
            if (!empty($item['partsBreakdown'])) {
                foreach ($item['partsBreakdown'] as $part) {
                    PartsPayment::create([
                        'email_payment_id' => $storage_data->id,
                        'name' => $part['name'],
                        'price' => $part['price'],
                    ]);
                }
            }
    
            // إضافة بيانات textures إذا كانت موجودة
            if (!empty($item['texturesBreakdown'])) {
                foreach ($item['texturesBreakdown'] as $texture) {
                    TexturesPayment::create([
                        'email_payment_id' => $storage_data->id,
                        'name' => $texture['name'],
                        'price' => $texture['price'],
                    ]);
                }
            }
        }
    
        session()->put('success', 'Cart details sent successfully!');
    
        return response()->json([
            'success' => 'Cart details sent successfully!',
            'redirect_url' => route('payment.success', ['payment_id' => $payment_id])
        ]);
    }
    

    public function cartDetails($payment_id)
    {
        $payments = EmailPayment::with(['user', 'parts', 'textures'])
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
    
        // dd($payments , $total_vat , $total_amount , $total_total);
        return view('payment.success', compact('payments', 'total_vat', 'total_amount', 'total_total', 'total_shipping_price'));
    }
    public function index()
    {
        $payments = EmailPayment::all();
        return response()->json(['data' => $payments], 200);
    }

    // get user payments
    public function userPayments($id)
    {
        $payments = EmailPayment::where('user_id', $id)->get();
        return response()->json(['data' => $payments], 200);
    }
}