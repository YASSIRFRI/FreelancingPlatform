<?php

use Illuminate\Http\Request;
use Flutterwave\EventHandlers\EventHandlerInterface;
use Flutterwave\Rave\Facades\Rave;

class PaymentController extends Controller {
    public function initiatePayment(Request $request) {
        $rave = new Rave(env('FLW_PUBLIC_KEY'), env('FLW_SECRET_KEY'));

        $data = [
            'amount' => $request->amount,
            'payment_type' => 'card',
            'currency' => $request->currency,
            'tx_ref' => uniqid(),
            'redirect_url' => url('/payment/callback'),
            'customer' => [
                'email' => $request->email,
                'name' => $request->name
            ],
            'meta' => [
                'price' => $request->amount
            ]
        ];

        $payment = $rave->initializePayment($data);

        if ($payment['status'] === 'success') {
            return redirect($payment['data']['link']);
        } else {
            return back()->withErrors(['error' => 'Failed to initiate payment.']);
        }
    }

    public function paymentCallback() {
        $rave = new Rave(env('FLW_PUBLIC_KEY'), env('FLW_SECRET_KEY'));
        $response = $rave->verifyTransaction(request()->tx_ref);

        if ($response['status'] === 'success') {
            // Payment successful
            return view('payment-success');
        } else {
            // Payment failed
            return view('payment-failure');
        }
    }
}
