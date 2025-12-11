<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Payment;
use App\Models\PartsPayment;
use App\Models\TexturesPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\CartMail;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;
use Exception;

class StripeController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        try {
            $request->validate([
                'total' => 'required|numeric|min:0',
                'shipping_price' => 'required|numeric|min:0',
                'items' => 'required|array|min:1',
                'user.id' => 'required|integer',
                'location' => 'required|array'
            ]);

            Stripe::setApiKey(config('services.stripe.secret'));

            $lineItems = collect($request->items)->map(function ($item) {
                return [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $item['name'],
                        ],
                        'unit_amount' => intval($item['price'] * 100),
                    ],
                    'quantity' => $item['quantity'],
                ];
            })->toArray();

            $total = $request->total + $request->shipping_price;

            $session = CheckoutSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('stripe.success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => url()->previous(),
                'metadata' => [
                    'user_email' => $request->user['email'] ?? 'guest',
                    'shipping' => json_encode($request->location),
                ],
            ]);

            // Save session data (similar to PayPal)
            session()->put('payment_data', [
                'items' => $request->items,
                'user' => $request->user,
                'shipping_price' => $request->shipping_price,
                'total' => $total,
                'location' => $request->location,
                'session_id' => $session->id,
            ]);

            if (empty($request->location['location_id'])) {
                Location::create([
                    'user_id' => $request->user['id'],
                    'first_name' => $request->location['first_name'],
                    'last_name' => $request->location['last_name'],
                    'country' => $request->location['country'],
                    'city' => $request->location['city'],
                    'street' => $request->location['street'],
                    'house_number' => $request->location['house_number'],
                    'zip_code' => $request->location['zipcode'],
                    'phone' => $request->location['phone'],
                ]);
            }

            return response()->json(['success' => true, 'url' => $session->url]);
        } catch (\Exception $e) {
            Log::error('Stripe payment creation error', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function success(Request $request)
    {
        try {
            if (!$request->has('session_id')) {
                Log::error('Stripe success callback missing session_id');
                return redirect()->route('cancel')->with('error', 'Payment session not found.');
            }

            Stripe::setApiKey(config('services.stripe.secret'));
            
            // Retrieve the Stripe session
            $session = CheckoutSession::retrieve($request->session_id);

            // Check if payment was successful
            if ($session->payment_status !== 'paid') {
                Log::warning('Stripe payment not paid', ['session_id' => $request->session_id, 'status' => $session->payment_status]);
                return redirect()->route('cancel')->with('error', 'Payment not completed.');
            }

            // Get payment data from session
            $paymentData = session()->get('payment_data');
            if (!$paymentData) {
                Log::error('Missing payment session data after Stripe success');
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
                'payment_method' => 'stripe',
                'payment_id' => $session->id,
            ];

            // Save payments to database
            foreach ($cartItems as $item) {
                $payment = Payment::create([
                    'payment_id' => $session->id,
                    'user_id' => $paymentData['user']['id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'currency' => strtoupper($session->currency ?? 'EUR'),
                    'payer_name' => $paymentData['location']['first_name'].' '.$paymentData['location']['last_name'],
                    'payer_email' => $session->customer_details->email ?? $paymentData['user']['email'] ?? null,
                    'country' => $paymentData['location']['country'] ?? '',
                    // 'city' => $paymentData['location']['city'] ?? '',
                    'street' => $paymentData['location']['street'] ?? '',
                    'house_number' => $paymentData['location']['house_number'] ?? '',
                    'zipcode' => $paymentData['location']['zipcode'] ?? '',
                    'phone' => $paymentData['location']['phone'] ?? '',
                    'shipping_price' => $shippingPrice,
                    'vat' => $item['vat'] ?? 0,
                    'amount' => $item['price'],
                    'total' => number_format($item['price'] * $item['quantity'], 2),
                    'payment_status' => 'Completed',
                    'payment_method' => 'stripe',
                    'status' => 'pending', // Default status
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
                    'city' => $paymentData['location']['city'],
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
                Log::error('Mail sending failed for Stripe payment', ['error' => $mailError->getMessage()]);
            }

            session()->forget('payment_data');
            session()->put('success', 'Payment completed successfully.');
            
            return redirect()->route('payment_stripe.success', ['payment_id' => $session->id]);

        } catch (Exception $e) {
            Log::error('Stripe success error', ['error' => $e->getMessage()]);
            return redirect()->route('cancel')->with('error', 'Something went wrong during payment processing.');
        }
    }

    public function cartDetails($payment_id)
    {
        $payments = Payment::with(['user', 'parts', 'textures'])
            ->where('payment_id', $payment_id)
            ->where('payment_method', 'stripe')
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
            $total_amount += ($payment->amount * $payment->quantity) + $payment->shipping_price;
    
            // حساب إجمالي الشحن
            $total_shipping_price += $payment->shipping_price;
    
            // حساب المجموع الكلي
            $total_total += $payment->total;
        }
    
        // خصم إجمالي الضريبة من المبلغ الإجمالي بدون الضريبة
        $total_amount -= $total_vat;
    
        return view('payment-success', [
            'message' => 'Your payment was successful!',
        ]);
    }
}