<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;

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
                'success_url' => route('stripe.success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => url()->previous(),
                'metadata' => [
                    'user_email' => $request->user['email'] ?? 'guest',
                    'shipping' => json_encode($request->location),
                ],
            ]);

	  if (empty($request->location['location_id'])) {
		Location::create([
		    'user_id' => $request->user['id'],
		    'first_name' => $request->location['first_name'],
		    'last_name' => $request->location['last_name'],
		    'country' => $request->location['country'],
		    'street' => $request->location['street'],
		    'house_number' => $request->location['house_number'],
		    'zip_code' => $request->location['zipcode'],
		    'phone' => $request->location['phone'],
		]);
	      }

            return response()->json(['success' => true, 'url' => $session->url]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function success(Request $request)
    {
	Log::info(session()->all());
        session()->forget('payment_data');
        session()->put('success', 'Payment completed successfully.');

        return view('payment-success', [
            'message' => 'Your payment was successful!',
        ]);
    }
}