<!-- resources/views/orders/show.blade.php -->

@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Order Details</h1>

    <!-- Order Information -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="p-6">
            <h2 class="text-xl font-bold mb-4">Order Summary</h2>

            <!-- Order Amount -->
            <div class="mb-4">
                <h3 class="text-lg font-semibold">Amount:</h3>
                <p class="text-green-600 font-bold">${{ number_format($order->price, 2) }}</p>
            </div>

            <!-- Order Description -->
            <div class="mb-4">
                <h3 class="text-lg font-semibold">Description:</h3>
                <p class="text-gray-700">{{ $order->description ?? 'No description provided.' }}</p>
            </div>

            <!-- Seller Information -->
            <div class="flex items-center mb-4">
                <img src="{{ $order->seller->profile_picture ? asset('storage/' . $order->seller->profile_picture) : 'https://via.placeholder.com/50' }}" alt="{{ $order->seller->name }}" class="w-12 h-12 rounded-full mr-4">
                <div>
                    <h4 class="text-lg font-semibold">{{ $order->seller->name }}</h4>
                    <p class="text-sm text-gray-600">{{ $order->seller->email }}</p>
                    <a href="{{ route('sellers.show', $order->seller->username) }}" class="text-blue-500 text-sm hover:underline">View Seller Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Order Information -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
        <h2 class="text-xl font-bold mb-4">Order Details</h2>

        <ul class="list-disc pl-5 text-gray-700">
            <li>Order ID: {{ $order->id }}</li>
            <li>Service: <a href="{{ route('services.show', $order->service->id) }}" class="text-blue-500 hover:underline">{{ $order->service->name }}</a></li>
            <li>Buyer: {{ $order->buyer->name }}</li>
            <li>Status: <span class="font-semibold">{{ ucfirst($order->status) }}</span></li>
            <li>Created At: {{ $order->created_at->format('F j, Y, g:i a') }}</li>
        </ul>
    </div>
</div>
@endsection
