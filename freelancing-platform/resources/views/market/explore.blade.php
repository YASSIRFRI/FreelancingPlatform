@extends('layouts.app')

@section('title', 'Explore Market')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Explore Market</h1>

    <!-- Search Form -->
    <form action="{{ route('market.explore') }}" method="GET" class="mb-8">
        <div class="flex items-center">
            <input type="text" name="query" placeholder="Search services by tag..." value="{{ request('query') }}" class="w-full p-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-r-md hover:bg-green-600">
                Search
            </button>
        </div>
    </form>

    <!-- Search Results -->
    @if ($query)
        <h2 class="text-2xl font-semibold mb-4">Results for "{{ $query }}"</h2>

        @if ($services->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($services as $service)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://via.placeholder.com/300' }}" alt="{{ $service->description }}" class="w-full h-48 object-cover">

                        <div class="p-4">
                            <h3 class="text-xl font-bold mb-2">{{ $service->description }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($service->description, 100) }}</p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-green-600 font-semibold">${{ number_format($service->price, 2) }}</span>
                                <span class="bg-gray-200 text-gray-800 text-sm px-2 py-1 rounded-full">{{ $service->tags }}</span>
                            </div>

                            <!-- Owner Information -->
                            @if ($service->user)
                            <div class="flex items-center mb-4">
                                <img src="{{ $service->user->profile_picture ? asset('storage/' . $service->user->profile_picture) : 'https://via.placeholder.com/50' }}" alt="{{ $service->user->name }}" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $service->user->name }}</h4>
                                    <a href="{{ route('sellers.show', $service->user->id) }}" class="text-blue-500 text-sm hover:underline">View Seller</a>
                                </div>
                            </div>
                            @else
                            <div class="flex items-center mb-4">
                                <img src="https://via.placeholder.com/50" alt="Unknown User" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <h4 class="font-semibold text-gray-800">Unknown User</h4>
                                    <span class="text-gray-500 text-sm">No seller information available</span>
                                </div>
                            </div>
                            @endif

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

            <!-- Pagination -->
            <div class="mt-8">
                {{ $services->appends(['query' => $query])->links() }}
            </div>
        @else
            <p class="text-red-600">No services found for your search criteria.</p>
        @endif
    @endif
</div>
@endsection
