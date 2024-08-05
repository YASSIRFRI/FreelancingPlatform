<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Deposit;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get the authenticated user

        // Fetch latest orders, deposits, and notifications
        $latestOrders = Order::where('buyer_id', $user->id)->latest()->take(5)->get();
        $latestDeposits = Deposit::where('user_id', $user->id)->latest()->take(5)->get();
        $notifications = Notification::where('user_id', $user->id)->latest()->take(5)->get();

        // Pass data to the view
        return view('dashboard', compact('user', 'latestOrders', 'latestDeposits', 'notifications'));
    }
}
