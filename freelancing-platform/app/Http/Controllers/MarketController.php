<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Review;


class MarketController extends Controller
{
    public function explore(Request $request)
    {
        $query = $request->input('query');
        $sellers = collect();
    
        if ($query) {
            $sellers = User::where('description', 'like', "%{$query}%")
                            ->with('reviews')
                            ->get();
    
            // Calculate the average rating for each seller
            $sellers = $sellers->map(function($seller) {
                $seller->averageRating = $seller->reviews()->avg('stars') ?: 0;
                return $seller;
            });
    
            $sellers = $sellers->sortByDesc('verified')
                               ->sortByDesc('averageRating');
    
            // Convert back to a paginator instance
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 10;
            $currentItems = $sellers->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $sellers = new LengthAwarePaginator($currentItems, $sellers->count(), $perPage);
        }
    
        $trendySellers = User::where('verified', true)
                             ->with('reviews')
                             ->get()
                             ->map(function($seller) {
                                 $seller->averageRating = $seller->reviews()->avg('stars') ?: 0;
                                 return $seller;
                             })
                             ->sortByDesc('averageRating')
                             ->take(6); // Fetch top 6 trendy sellers
    
        $user = auth()->user();
        return view('market.explore', compact('sellers', 'query', 'user', 'trendySellers'));
    }
    
    
}
