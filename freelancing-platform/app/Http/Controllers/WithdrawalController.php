<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        return view('withdrawals.index', compact('withdrawals'));
    }

    /**
     * Show the form for creating a new withdrawal.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('withdrawals.create');
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

        // Create a new withdrawal for the authenticated user
        Withdrawal::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'state' => 'pending',
        ]);

        return redirect()->route('withdrawals.index')->with('success', 'Withdrawal request submitted.');
    }
}
