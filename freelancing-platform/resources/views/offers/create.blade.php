@extends('layouts.app')

@section('title', 'Create Offer')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-green-400 text-3xl font-bold mb-6">Send Offer to: 
        <div class="flex-col m-3">
        <div class="text-green-800 inline font-semibold">{{ $seller->name }}
        <div class="text-green-600 text-sm font-semibold">{{ $seller->email }}</div>
         <img src="{{ $seller->profile_picture ? asset('storage/' . $seller->profile_picture) : 'https://via.placeholder.com/150' }}" alt="{{ $seller->name }}" class="w-12 h-12 rounded-full inline-block ml-2">
        </div>
        </div>
    </h1>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Offer Form -->
    <form action="{{ route('offers.store') }}" method="POST" class="mb-8">
        @csrf
        <input type="hidden" name="seller_id" value="{{ $seller->id }}">

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required></textarea>
        </div>

        <div class="mb-4">
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
            <input type="number" id="amount" name="amount" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
        </div>

        <div class="mb-4">
            <label for="amount" class="block text-sm font-medium text-gray-700">Revisions</label>
            <input type="number" max='10' min="1" id="revisions" name="revisions" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
        </div>

        <div class="mb-4">
            <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
            <input type="date" id="deadline" name="deadline" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Submit Offer <i class="fas fa-check ml-2"></i></button>
    </form>
</div>
@endsection
