@extends('layouts.app')

@section('title', 'Seller Profile')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-green-400 text-3xl font-bold mb-6">{{ $seller->name }}'s Profile</h1>

    <!-- Seller Profile Section -->
    <div class="bg-white p-6 shadow-md rounded-lg mb-6">
        <div class="flex items-center mb-4">
            <div class="flex flex-col items-center">
                <img src="{{ $seller->profile_picture ? asset('storage/' . $seller->profile_picture) : 'https://via.placeholder.com/80' }}" alt="Profile Picture" class="h-20 w-20 rounded-full mr-4">
                <span class="text-sm font-semibold mt-4">
                    @if ($seller->verified)
                        <span class="inline-block bg-green-200 text-green-800 px-3 py-1 rounded-full">Verified</span>
                    @else
                        <span class="inline-block bg-red-200 text-red-800 px-3 py-1 rounded-full">Not Verified</span>
                    @endif
                </span>
            </div>
            
            <!-- Display Average Rating -->
            <div class="ml-8 flex items-center">
                @php
                    $rating = $averageRating;
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

                <span class="ml-2 text-gray-700">{{ round($averageRating, 2) }} / 5</span>
            </div>
        </div>

        <!-- Seller Description -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <p class="text-gray-600 mt-2">{{ $seller->description }}</p>
        </div>
    </div>

    <!-- Share Account Link Section -->
    <div class="bg-white p-6 shadow-md rounded-lg mb-6">
        <h2 class="text-xl font-bold mb-4">Share Your Profile Link</h2>
        <div class="flex items-center">
            <input type="text" id="profileLink" class="border border-gray-300 rounded-lg p-2 w-full sm:w-2/3 text-gray-700" value="{{ url('/profile/' . $seller->id) }}" readonly>
            <button onclick="copyToClipboard()" class="ml-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                <i class="fas fa-copy mr-2"></i>Copy Link
            </button>
        </div>
        <p id="copyMessage" class="text-green-500 mt-2 hidden">Copied to clipboard!</p>
    </div>

    <!-- Recent Reviews Section -->
    <h2 class="text-2xl font-bold mb-4">Recent Reviews</h2>
    <div class="bg-white p-6 shadow-md rounded-lg overflow-x-auto">
        <div class="flex space-x-4">
            @foreach ($recentReviews as $review)
                <div class="min-w-[250px] bg-gray-50 border border-gray-200 rounded-lg shadow-sm p-4 transition-transform transform hover:scale-105">
                    <div class="flex items-center mb-2">
                        @php
                            $rating = $review->stars;
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
                    </div>
                    <p class="text-gray-600 mb-4">{{ Str::limit($review->comment, 100) }}</p>
                    <div class="flex items-center">
                        <img src="{{ $review->buyer->profile_picture ? asset('storage/' . $review->buyer->profile_picture) : 'https://via.placeholder.com/50' }}" alt="Reviewer Picture" class="h-10 w-10 rounded-full mr-3">
                        <div>
                            <h4 class="font-semibold text-gray-800">{{ $review->buyer->name }}</h4>
                            <p class="text-gray-500 text-sm">{{ $review->buyer->email }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function copyToClipboard() {
        var copyText = document.getElementById("profileLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */
        document.execCommand("copy");

        // Show the "Copied" message
        var copyMessage = document.getElementById("copyMessage");
        copyMessage.classList.remove("hidden");

        // Hide the message after 3 seconds
        setTimeout(function() {
            copyMessage.classList.add("hidden");
        }, 3000);
    }
</script>
@endsection
