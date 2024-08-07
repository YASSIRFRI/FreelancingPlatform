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
        $user->balance += $request->amount;
        Deposit::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'state' => 'pending',
        ]);

        return redirect()->route('deposits.index')->with('success', 'Deposit request submitted.');
    }
}
