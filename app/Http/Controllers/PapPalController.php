<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;

class PapPalController extends Controller
{

    public function payment(Request $request)
    {
        dd($request->all());
        $validated = $request->validate([
            'items' => 'required|array',
            'total' => 'required|numeric',
        ]);

        $data = [];
        $data['items'] = [];

        foreach ($validated['items'] as $item) {
            $data['items'][] = [
                'name' => $item['name'],
                'price' => $item['price'],
                'desc' => 'Product purchase',
                'qty' => $item['quantity']
            ];
        }

        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');
        $data['total'] = $validated['total'];

        $provider = new ExpressCheckout;

        $response = $provider->setExpressCheckout($data);
        $response = $provider->setExpressCheckout($data, true);

        return response()->json(['redirect_url' => $response['paypal_link']]);
    }
    public function cancel()
    {
        dd('Your payment is canceled.');
    }

    public function success(Request $request)
    {
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            dd($response);
            // return response()->json([
            //     'data' => $response
            // ]);
        }

        dd('Please try again later.');
    }
}
