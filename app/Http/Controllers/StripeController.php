<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

class StripeController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        try {
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

            $session = CheckoutSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => url()->previous(),
                'metadata' => [
                    'user_email' => $request->user['email'] ?? 'guest',
                    'shipping' => json_encode($request->location),
                ],
            ]);
	  

            return response()->json(['success' => true, 'url' => $session->url]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function success(Request $request)
    {
	session()->forget('payment_data');
	session()->put('success', 'Payment completed successfully.');
        return view('payment-success', [
            'message' => 'Your payment was successful!',
        ]);
    }
}