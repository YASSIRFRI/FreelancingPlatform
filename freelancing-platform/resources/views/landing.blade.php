@extends('layouts.app')

@section('title', 'Landing')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="flex flex-col items-center bg-white shadow-md rounded-lg p-8 w-full max-w-4xl">
        <!-- SVG Image -->
        <div class="w-full flex justify-center items-center mb-8">
            <img src="{{ asset('EZA.svg') }}" alt="EZA Logo" class="max-w-xs">
        </div>

        <!-- Next Button as SVG -->
        <div class="w-full flex justify-center items-center mt-8">
            <a href="{{ url('/next') }}">
                <img src="{{ asset('NEXT.svg') }}" alt="Next Button" class="max-w-xs cursor-pointer">
            </a>
        </div>
    </div>
</div>
@endsection
