<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Flutterwave\Payments\Data\Currency;
use Flutterwave\Payments\Facades\Flutterwave;

class DepositController extends Controller
{
    /**
     * Display a listing of the deposits.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // Use pagination instead of get()
        $deposits = Deposit::where('user_id', $user->id)->latest()->paginate(10);
        return view('deposits.index', compact('deposits', 'user'));
    }

    /**
     * Show the form for creating a new deposit.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('deposits.create', compact('user'));
    }

    /**
     * Store a newly created deposit in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);
    
        $user = Auth::user();
        $payload = [
            "tx_ref" => Flutterwave::generateTransactionReference(),
            "amount" => $request->amount,
            "currency" => Currency::USD, // or NGN or your preferred currency
            "customer" => [
                "email" => $user->email,
            ],
        ];
        
        $payment_details = Flutterwave::render('inline', $payload);
        return view('flutterwave::modal', compact('payment_details'));
        // For standard modal (uncomment if using this option)
        //$payment_link = Flutterwave::render('standard', $payload);
        //return redirect($payment_link);
    }

    public function paymentCallback(Request $request)
    {
        $tx_ref = $request->tx_ref;
        $transaction = Flutterwave::use('transactions');
        $response = $transaction->verifyTransactionReference($tx_ref);

        if ($response['status'] === 'success') {
            $deposit = Deposit::create([
                'user_id' => Auth::id(),
                'amount' => $response['data']['amount'],
                'state' => 'completed',
            ]);

            $user = Auth::user();
            $user->balance += $response['data']['amount'];
            $user->save();

            return redirect()->route('deposits.index')->with('success', 'Deposit successful.');
        } else {
            return redirect()->route('deposits.index')->with('error', 'Payment failed.');
        }
    }

}
