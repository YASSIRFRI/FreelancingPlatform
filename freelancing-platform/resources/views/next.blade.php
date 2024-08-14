@extends('layouts.guest')

@section('title', 'Next')

@section('content')
<div class="flex justify-between items-center bg-white mt-2 p-4 shadow-md">
    <!-- Logo Text -->
    <div class="flex items-center">
        <span class="flex items-center text-2xl font-bold text-gray-800">
            Eza<span class="text-green-500 ml-1">.</span>
        </span>
    </div>
</div>

<div class="flex items-center justify-center min-h-screen">
    <div class="flex flex-col items-center bg-white shadow-md rounded-lg p-8 w-full max-w-4xl">
        <!-- SVG Image -->
        <div class="w-full flex justify-center items-center mb-8">
            <img src="{{ asset('UPDATED.svg') }}" alt="UPDATED Logo" class="max-w-md">
        </div>

        <!-- Get Started Button -->
        <div class="w-full flex justify-center items-center mt-8">
            <a href="{{ url('/login') }}">
                <img src="{{ asset('NEXT.svg') }}" alt="Get Started Button" class="max-w-xs cursor-pointer">
            </a>
        </div>
    </div>
</div>
@endsection
