<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function show($id)
    {
        $seller = User::findOrFail($id);
        $user = auth()->user();
        $recentReviews = Review::whereHas('order', function($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })->latest()->take(10)->get();
    
        $averageRating = Review::whereHas('order', function ($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })->avg('stars');
    
        return view('sellers.profile', compact('seller', 'recentReviews', 'averageRating','user'));
    }
}
