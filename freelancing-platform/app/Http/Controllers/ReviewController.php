<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create($id)
    {
        $order = Order::findOrFail($id);
        $user = auth()->user();
        return view('reviews.create', compact('order', 'user'));
    }

    public function store(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = new Review;
        $review->buyer_id = $order->buyer_id; // Assuming the buyer_id is related to the order
        $review->order_id = $order->id;
        $review->stars = $request->stars;
        $review->comment = $request->comment;
        $review->save();
        $order->review_id = $review->id;
        $order->save();

        return redirect()->route('buying.dashboard', $order->id)->with('success', 'Review submitted successfully.');
    }

    public function index(Request $request)
    {
        $sellerId = auth()->user()->id; // Assuming the seller is the authenticated user
        $reviews = Review::whereHas('order', function($query) use ($sellerId) {
            $query->where('seller_id', $sellerId); // Assuming the Order model has a seller_id field
        })->get();

        return view('reviews.index', compact('reviews'));
    }
}
