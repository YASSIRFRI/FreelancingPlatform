@extends('layouts.guest')

@section('title', 'Terms and Conditions')

@section('content')
<div class="flex justify-between items-center bg-white mt-2 p-4 shadow-md">
    <!-- Logo Text -->
    <div class="flex items-center">
        <span class="flex items-center text-2xl font-bold text-gray-800">
            Eza<span class="text-green-500 ml-1">.</span>
        </span>
    </div>
</div>

<div class="flex items-center justify-center min-h-screen mt-4">
    <div class="bg-white shadow-md rounded-lg w-full max-w-4xl">
        <div class="w-full">
            @php
                $termsConditionsContent = Storage::get('terms_conditions.html');
            @endphp

            {!! $termsConditionsContent !!}
        </div>
    </div>
</div>
@endsection
