<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    /**
     * Display a listing of the deposits.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch deposits for the authenticated user
        $deposits = Auth::user()->deposits()->orderBy('created_at', 'desc')->get();
        
        return view('deposits.index', compact('deposits'));
    }

    /**
     * Show the form for creating a new deposit.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('deposits.create');
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

        // Create a new deposit for the authenticated user
        Deposit::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'state' => 'pending',
        ]);

        return redirect()->route('deposits.index')->with('success', 'Deposit request submitted.');
    }
}
