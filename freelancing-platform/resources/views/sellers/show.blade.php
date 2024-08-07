<!-- resources/views/sellers/show.blade.php -->

@extends('layouts.app')

@section('title', $seller->name . ' - Seller Profile')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex items-center p-4">
            <!-- Profile Picture -->
            <img src="{{ $seller->profile_picture ? asset('storage/' . $seller->profile_picture) : 'https://via.placeholder.com/150' }}" alt="{{ $seller->name }}" class="w-20 h-20 rounded-full mr-4">
            
            <!-- Seller Information -->
            <div>
                <h1 class="text-2xl font-bold">{{ $seller->name }}</h1>
                <p class="text-gray-600">{{ $seller->bio ?? 'No bio available.' }}</p>
            </div>
        </div>

        <!-- Seller's Services -->
        <div class="p-4">
            <h2 class="text-xl font-semibold mb-4">Services Offered</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($seller->services as $service)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://via.placeholder.com/300' }}" alt="{{ $service->description }}" class="w-full h-48 object-cover">

                        <div class="p-4">
                            <h3 class="text-xl font-bold mb-2">{{ $service->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($service->description, 100) }}</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-green-600 font-semibold">${{ number_format($service->price, 2) }}</span>
                                <span class="bg-gray-200 text-gray-800 text-sm px-2 py-1 rounded-full">{{ $service->tags }}</span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-between">
                                <a href="{{ route('order.create', $service->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                                    Order Now
                                </a>
                                <a href="{{ route('services.show', $service->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
