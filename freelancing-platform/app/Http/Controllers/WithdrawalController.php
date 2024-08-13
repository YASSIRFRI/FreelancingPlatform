<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
     * Store a newly created withdrawal in storage.
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

        return redirect()->route('withdrawals.index')->with('success', 'Withdrawal request submitted and is pending approval.');
    }
}
