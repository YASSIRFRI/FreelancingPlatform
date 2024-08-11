@extends('layouts.app')

@section('title', 'Explore Market')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-green-500 text-3xl font-bold mb-6">Explore Sellers<i class="fas fa-store ml-2"></i></h1>

    <!-- Search Form -->
    <form action="{{ route('market.explore') }}" method="GET" class="mb-8">
        <div class="relative flex items-center">
            <input type="text" name="query" placeholder="Search for services, skills, or sellers..." value="{{ request('query') }}" class="w-full p-3 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-green-500 shadow-md" required>
            <button type="submit" class="bg-green-500 text-white px-4 py-3 rounded-r-md hover:bg-green-600 transition">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    <!-- Popular Tags -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Popular Tags</h2>
        <div class="flex flex-wrap gap-2">
            @foreach (['PHP', 'Python', 'Graphic Design', 'Voice Over', 'Web Development', 'SEO Optimization', 'Content Writing', 'Video Editing', 'Digital Marketing', 'Data Analysis'] as $tag)
                <a href="{{ route('market.explore', ['query' => $tag]) }}" class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold hover:bg-blue-200 transition">{{ $tag }}</a>
            @endforeach
        </div>
    </div>

    <!-- Search Results -->
    @if ($query)
        <h2 class="text-2xl font-semibold mb-4">Results for <i class="fas fa-search ml-2"></i>
            <span class="text-red-500">"{{ $query }}"</span>
        </h2>

        @if ($sellers->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($sellers as $seller)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-4">
                            <div class="flex items-center mb-4">
                                <img src="{{ $seller->profile_picture ? asset('storage/' . $seller->profile_picture) : 'https://via.placeholder.com/50' }}" alt="{{ $seller->name }}" class="w-16 h-16 rounded-full mr-3">
                                <div>
                                    <h4 class="font-semibold text-gray-800">{{ $seller->name }}</h4>
                                    
                                    <!-- Display Average Rating -->
                                    <div class="flex items-center mt-2">
                                        @php
                                            $rating = $seller->averageRating;
                                            $fullStars = floor($rating);
                                            $halfStar = ($rating - $fullStars) >= 0.5 ? true : false;
                                        @endphp

                                        @for ($i = 0; $i < $fullStars; $i++)
                                            <i class="fas fa-star text-yellow-500"></i>
                                        @endfor

                                        @if ($halfStar)
                                            <i class="fas fa-star-half-alt text-yellow-500"></i>
                                        @endif

                                        @for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++)
                                            <i class="far fa-star text-yellow-500"></i>
                                        @endfor

                                        <span class="ml-2 text-gray-700">{{ round($rating, 2) }} / 5</span>
                                    </div>

                                    <div class="flex items-center mt-2">
                                        <span class="px-2 py-1 rounded-full text-sm font-semibold {{ $seller->verified ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $seller->verified ? 'Verified' : 'Not Verified' }}
                                        </span>
                                    </div>
                                    <a href="{{ route('sellers.show', $seller->id) }}" class="text-green-500 text-sm hover:underline mt-2">View Seller <i class="fas fa-arrow-right ml-1"></i></a>
                                </div>
                            </div>
                            <div class="mb-4">
                                <p class="text-gray-600">{{ Str::limit($seller->description, 100) }}</p>
                            </div>
                            <div class="flex justify-between">
                                <a href="{{ route('offers.create', $seller->id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                                    Create Offer <i class="fas fa-paper-plane ml-1"></i>
                                </a>
                                <a href="{{ route('sellers.show', $seller->id) }}" class="text-green-600 hover:text-green-800 text-sm">
                                    View Details <i class="fas fa-info-circle ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $sellers->appends(['query' => $query])->links() }}
            </div>
        @else
            <p class="text-red-600">No sellers found for your search criteria.</p>
        @endif
    @endif

    <div class="mt-12">
        <h2 class="text-red-600 text-2xl font-semibold mb-4">Trendy Sellers <i class="fas fa-fire text-red-500 ml-2"></i></h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($trendySellers as $seller)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-center mb-4">
                            <img src="{{ $seller->profile_picture ? asset('storage/' . $seller->profile_picture) : 'https://via.placeholder.com/50' }}" alt="{{ $seller->name }}" class="w-16 h-16 rounded-full mr-3">
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $seller->name }}</h4>
                                
                                <!-- Display Average Rating -->
                                <div class="flex items-center mt-2">
                                    @php
                                        $rating = $seller->averageRating;
                                        $fullStars = floor($rating);
                                        $halfStar = ($rating - $fullStars) >= 0.5 ? true : false;
                                    @endphp

                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star text-yellow-500"></i>
                                    @endfor

                                    @if ($halfStar)
                                        <i class="fas fa-star-half-alt text-yellow-500"></i>
                                    @endif

                                    @for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++)
                                        <i class="far fa-star text-yellow-500"></i>
                                    @endfor

                                    <span class="ml-2 text-gray-700">{{ round($rating, 2) }} / 5</span>
                                </div>

                                <div class="flex items-center mt-2">
                                    <span class="px-2 py-1 rounded-full text-sm font-semibold {{ $seller->verified ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $seller->verified ? 'Verified' : 'Not Verified' }}
                                    </span>
                                </div>
                                <a href="{{ route('sellers.show', $seller->id) }}" class="text-green-500 text-sm hover:underline mt-2">View Seller <i class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-600">{{ Str::limit($seller->description, 100) }}</p>
                        </div>
                        <div class="flex justify-between">
                            <a href="{{ route('offers.create', $seller->id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                                Create Offer <i class="fas fa-paper-plane ml-1"></i>
                            </a>
                            <a href="{{ route('sellers.show', $seller->id) }}" class="text-green-600 hover:text-green-800 text-sm">
                                View Details <i class="fas fa-info-circle ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
