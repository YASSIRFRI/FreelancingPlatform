<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderCreatedNotification;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Retrieve orders where the user is the seller, with pagination
        $orders = Order::where('seller_id', $user->id)->latest()->paginate(10);

        // Pass both orders and user to the view
        return view('orders.index', compact('orders', 'user'));
    }

    /**
     * Show the form for creating a new order.
     *
     * @return \Illuminate\View\View
     */
    public function create($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $user=Auth::user();
        return view('orders.create', compact('service','user'));
    }

    public function store(Request $request, $serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $buyer = Auth::user();
        $seller = User::findOrFail($service->user_id);

        $request->validate([
            'description' => 'nullable|string|max:500',
        ]);

        $order = new Order();
        $order->buyer_id = $buyer->id;
        $order->seller_id = $seller->id;
        $order->service_id = $service->id;
        $order->amount = $service->price;
        $order->description = $request->description;
        $order->status = 'pending';
        $order->save();
        $seller->notify(new OrderCreatedNotification($order));

        return redirect()->route('orders.show', $order->id)
                         ->with('success', 'Order placed successfully!');
    }


    /**
     * Display the specified order.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Find the order by its ID
        $order = Order::with(['buyer', 'seller', 'service'])->findOrFail($id);
        $user=Auth::user();

        // Return the order details view
        return view('orders.show', compact('order','user'));
    }
}
