<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    // Display the specified seller
    public function show($username)
    {
        // Find the user by username
        $seller = User::where('username', $username)->firstOrFail();

        // Pass the seller data to the view
        return view('sellers.show', compact('seller'));
    }
}
