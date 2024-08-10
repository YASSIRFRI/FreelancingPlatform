<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Flutterwave\Rave\Facades\Rave as Flutterwave;
use Illuminate\Support\Facades\Log;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of the withdrawals.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch withdrawals for the authenticated user
        $withdrawals = Auth::user()->withdrawals()->orderBy('created_at', 'desc')->get();
        $user = Auth::user();
        return view('withdrawals.index', compact('withdrawals', 'user'));
    }

    /**
     * Show the form for creating a new withdrawal.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('withdrawals.create', compact('user'));
    }

    /**
     * Store a newly created withdrawal in storage and initialize the payment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Check if the user has enough balance
        $user = Auth::user();
        if ($request->amount > $user->balance) {
            return redirect()->route('withdrawals.index')->with('error', 'Insufficient balance.');
        }

        // Create the withdrawal record as pending
        $withdrawal = Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'state' => 'pending',
            'created_at' => Carbon::now(),
        ]);

        // Store the withdrawal ID in the session
        session(['withdrawal_id' => $withdrawal->id]);

        // Initialize the Flutterwave payment
        $redirectUrl = route('withdrawals.index');
        $paymentData = [
            'tx_ref' => uniqid(), // Unique transaction reference
            'amount' => $withdrawal->amount,
            'currency' => 'NGN', 
            'redirect_url' => $redirectUrl,
            'customer' => [
                'email' => $user->email,
                'name' => $user->name,
            ],
        ];

        return Flutterwave::initializePayment($paymentData);
    }

    /**
     * Handle the callback after payment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request)
    {
        $withdrawalId = session('withdrawal_id');
        if (!$withdrawalId) {
            return redirect()->route('withdrawals.index')->with('error', 'Session expired. Please try again.');
        }

        $withdrawal = Withdrawal::findOrFail($withdrawalId);

        // Verify the transaction
        $transaction = Flutterwave::verifyTransaction($request->tx_ref);

        if ($transaction->status === "successful" && $transaction->data->amount == $withdrawal->amount) {
            // Update withdrawal state and user balance
            $withdrawal->update([
                'state' => 'completed',
            ]);

            $user = Auth::user();
            $user->balance -= $withdrawal->amount;
            $user->save();

            return redirect()->route('withdrawals.index')->with('success', 'Withdrawal was successful!');
        } else {
            // Update withdrawal state to failed
            $withdrawal->update(['state' => 'failed']);
            return redirect()->route('withdrawals.index')->with('error', 'Withdrawal failed, please try again.');
        }
    }
}
