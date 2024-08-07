<!-- resources/views/services/show.blade.php -->

@extends('layouts.app')

@section('title', $service->name)

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">{{ $service->name }}</h1>

    <!-- Service Image -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://via.placeholder.com/600' }}" alt="{{ $service->name }}" class="w-full h-64 object-cover">
    </div>

    <!-- Service Information -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
        <p class="text-gray-600 mb-4">{{ $service->description }}</p>
        <span class="text-green-600 font-semibold text-lg">${{ number_format($service->price, 2) }}</span>

        <!-- Seller Information -->
        <div class="flex items-center mt-6">
            <img src="{{ $service->user->profile_picture ? asset('storage/' . $service->user->profile_picture) : 'https://via.placeholder.com/50' }}" alt="{{ $service->user->name }}" class="w-12 h-12 rounded-full mr-4">
            <div>
                <h4 class="font-semibold text-gray-800">{{ $service->user->name }}</h4>
                <a href="{{ route('sellers.show', $service->user->username) }}" class="text-blue-500 text-sm hover:underline">View Seller</a>
            </div>
        </div>
    </div>

    <!-- Order Now Button -->
    <div class="mt-6">
        <a href="{{ route('order.create', $service->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Order Now
        </a>
    </div>
</div>
@endsection
