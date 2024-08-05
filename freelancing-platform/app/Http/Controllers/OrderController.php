<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all orders for the authenticated user as a buyer
        $orders = Order::where('buyer_id', Auth::id())->latest()->get();

        // Return the orders index view
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Retrieve all available services
        $services = Service::all();

        // Return the order creation form view
        return view('orders.create', compact('services'));
    }

    /**
     * Store a newly created order in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'amount' => 'required|numeric|min:0',
        ]);

        // Find the selected service
        $service = Service::findOrFail($request->service_id);

        // Create a new order
        Order::create([
            'buyer_id' => Auth::id(),
            'seller_id' => $service->seller_id,
            'service_id' => $service->id,
            'status' => 'pending', // Default status
            'amount' => $request->amount,
        ]);

        // Redirect to the orders index page with a success message
        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
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
        $order = Order::findOrFail($id);

        // Return the order details view
        return view('orders.show', compact('order'));
    }
}
