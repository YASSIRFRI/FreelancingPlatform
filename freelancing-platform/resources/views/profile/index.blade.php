@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-green-400 text-3xl font-bold mb-6">My Profile</h1>

    <!-- Success & Error Messages -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Profile Update Section -->
    <div class="bg-white p-6 shadow-md rounded-lg mb-6">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Profile Picture and Verification Status -->
            <div class="flex items-center mb-4">
                <div class="flex flex-col items-center">
                    <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://via.placeholder.com/80' }}" alt="Profile Picture" class="h-20 w-20 rounded-full mr-4">
                    <span class="text-sm font-semibold mt-4">
                        @if ($user->verified)
                            <span class="inline-block bg-green-200 text-green-800 px-3 py-1 rounded-full">Verified</span>
                        @else
                            <span class="inline-block bg-red-200 text-red-800 px-3 py-1 rounded-full">Not Verified</span>
                        @endif
                    </span>
                </div>

                <!-- Profile Picture Upload -->
                <div class="flex flex-col">
                    <label class="block text-sm font-medium text-gray-700 mt-2">Profile Picture</label>
                    <label class="flex items-center px-4 py-2 bg-white text-green-600 rounded-md shadow-md tracking-wide border border-green-600 cursor-pointer hover:bg-green-600 hover:text-white">
                        <span class="text-base leading-normal">Select a file</span>
                        <input type="file" name="profile_picture" class="hidden" onchange="showPreview(event, 'profile_picture_preview')">
                    </label>
                    <img id="profile_picture_preview" src="" class="mt-2 h-20 w-20 rounded-full hidden">
                    @error('profile_picture')
                        <div class="text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Display Average Rating -->
            <div class="flex items-center mb-4">
                <div class="ml-4 flex items-center">
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

            <!-- Name Field -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2">
                @error('name')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2">
                @error('email')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description Field -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2" rows="4">{{ $user->description }}</textarea>
                @error('description')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Update Profile Button -->
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Update Profile
            </button>
        </form>
    </div>

    <!-- Verification Request Form -->
    <div class="bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-2xl font-bold mb-4">Verification Request</h2>
        @if($user->verificationRequests()->where('status', 'pending')->exists())
            <p class="text-yellow-600">Your verification request is pending.</p>
        @elseif($user->verified)
            <p class="text-green-600">Your account is verified.</p>
        @else
            <form action="{{ route('verification.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="verification_paper" class="block text-sm font-medium text-gray-700">1. Please upload a clear picture of your National ID Card or Passport.<span class='text-red-500'>(Max 15MB)</span></label>
                    <label class="flex items-center px-4 py-2 bg-white text-green-600 rounded-md shadow-md tracking-wide border border-green-600 cursor-pointer hover:bg-green-600 hover:text-white">
                        <span class="text-base leading-normal">Select a file</span>
                        <input type="file" name="verification_paper" id="verification_paper" class="hidden" onchange="showPreview(event, 'verification_paper_preview')">
                    </label>
                    <img id="verification_paper_preview" src="" class="mt-2 h-20 w-20 hidden">
                    @error('verification_paper')
                        <div class="text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="verification_image" class="block text-sm font-medium text-gray-700">2. Please take a selfie of you holding Your card. The picture should be very clear.<span class='text-red-500'>(Max 15MB)</span></label>
                    <label class="flex items-center px-4 py-2 bg-white text-green-600 rounded-md shadow-md tracking-wide border border-green-600 cursor-pointer hover:bg-green-600 hover:text-white">
                        <span class="text-base leading-normal">Select a file</span>
                        <input type="file" name="verification_image" id="verification_image" accept="image/*" class="hidden" onchange="showPreview(event, 'verification_image_preview')" capture="user">
                    </label>
                    <img id="verification_image_preview" src="" class="mt-2 h-20 w-20 hidden">
                    @error('verification_image')
                        <div class="text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Submit Verification <i class="fas fa-check ml-2"></i>
                </button>
            </form>
        @endif
    </div>
</div>

<script>
    function showPreview(event, previewId) {
        const preview = document.getElementById(previewId);
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
