@extends('layouts.app')

@section('title', 'My Services')

@section('username', Auth::user()->name)

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">My Services</h1>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($services as $service)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Service Image -->
                <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://via.placeholder.com/300' }}" alt="{{ $service->name }}" class="w-full h-48 object-cover">

                <!-- Card Content -->
                <div class="p-4">
                    <!-- Tags -->
                    @if ($service->tag)
                        @foreach (explode(',', $service->tag) as $tag)
                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mb-2">{{ trim($tag) }}</span>
                        @endforeach
                    @endif

                    <!-- Service Name -->
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $service->name }}</h2>

                    <!-- Description -->
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($service->description, 50) }}</p>

                    <!-- Price -->
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-green-500">${{ number_format($service->price, 2) }}</span>
                        <a href="{{ route('services.edit', $service->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit
                            <i class="fas fa-edit ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="mt-8">
        {{ $services->links() }}
    </div>

    <!-- Button to Create New Service -->
    <div class="mb-8">
        <a href="{{ route('services.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
             New Service <i class="fas fa-plus-circle ml-1"></i>
        </a>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'My Services')

@section('username', Auth::user()->name)

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">My Services</h1>

    <!-- Services Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($services as $service)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Service Image -->
                <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://via.placeholder.com/300' }}" alt="{{ $service->name }}" class="w-full h-48 object-cover">

                <!-- Card Content -->
                <div class="p-4">
                    <!-- Tags -->
                    @if ($service->tag)
                        @foreach (explode(',', $service->tag) as $tag)
                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mb-2">{{ trim($tag) }}</span>
                        @endforeach
                    @endif

                    <!-- Service Name -->
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $service->name }}</h2>

                    <!-- Description -->
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($service->description, 50) }}</p>

                    <!-- Price -->
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-green-500">${{ number_format($service->price, 2) }}</span>
                        <a href="{{ route('services.edit', $service->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit
                            <i class="fas fa-edit ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="mt-8">
        {{ $services->links() }}
    </div>

    <!-- Button to Create New Service -->
    <div class="mb-8">
        <a href="{{ route('services.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
             New Service <i class="fas fa-plus-circle ml-1"></i>
        </a>
    </div>
</div>
@endsection
