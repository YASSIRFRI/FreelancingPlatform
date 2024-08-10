<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Review;


class MarketController extends Controller
{
    public function explore(Request $request)
    {
        $query = $request->input('query');
        $sellers = collect();

        if ($query) {
            $sellers = User::where('description', 'like', "%{$query}%")->paginate(10); // Use pagination here
        }
        foreach ($sellers as $seller) {
            $seller->averageRating = Review::whereHas('order', function ($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            })->avg('stars');
        }

        $user = auth()->user();
        return view('market.explore', compact('sellers', 'query', 'user'));
    }
}
