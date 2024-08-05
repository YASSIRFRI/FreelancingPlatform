@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container mx-auto">
    <!-- Enhanced Title -->
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">My Profile</h1>
        <i class="fas fa-user-circle text-green-500 text-4xl"></i> <!-- Adding an icon for visual enhancement -->
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Profile Form -->
    <div class="bg-white p-6 shadow-md rounded-lg">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex items-center mb-4">
                <!-- Display the Profile Picture -->
                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://via.placeholder.com/80' }}" alt="Profile Picture" class="h-20 w-20 rounded-full mr-4">
                
                <!-- Custom File Upload Input -->
                <div class="flex flex-col">
                    <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
                    <label class="flex items-center px-4 py-2 bg-white text-green-600 rounded-md shadow-md tracking-wide border border-green-600 cursor-pointer hover:bg-green-600 hover:text-white transition-all">
                        <span class="text-base leading-normal">Select a file</span>
                        <input type="file" name="profile_picture" class="hidden">
                    </label>
                    @error('profile_picture')
                        <div class="text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2">
                @error('name')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2">
                @error('email')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2" rows="4">{{ $user->description }}</textarea>
                @error('description')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Update Profile
            </button>
        </form>
    </div>
</div>
@endsection
