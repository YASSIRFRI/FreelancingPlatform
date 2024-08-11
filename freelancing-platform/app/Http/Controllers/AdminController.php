<?php


namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Offer;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user=auth()->user();
        $verificationRequests = VerificationRequest::with('user')->where('status', 'pending')->get();

        $todaysEarnings = Order::whereDate('created_at', now()->today())->sum('fee') + Offer::whereDate('created_at', now()->today())->sum('fee');
        $overallEarnings = Order::sum('fee') + Offer::sum('fee');


        // Fetch recent orders
        $recentOrders = Order::with('seller')->latest()->take(10)->get();

        return view('admin.dashboard', compact('verificationRequests', 'todaysEarnings', 'overallEarnings', 'recentOrders','user'));
    }

    public function approveVerification($id)
    {
        $verificationRequest = VerificationRequest::findOrFail($id);
        $verificationRequest->status = 'approved';
        $verificationRequest->save();
        // Optionally, you can update the user to mark them as verified
        $verificationRequest->user->verified = true;
        $verificationRequest->user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Verification request approved successfully.');
    }
}
