@extends('layouts.app')

@section('title', 'Edit Offer')

@section('content')
<div class="container mx-auto px-4 py-8 bg-white shadow-md rounded-lg">
    <h1 class="text-3xl font-bold mb-6">Edit Offer</h1>

    <form action="{{ route('offers.update', $offer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea id="description" name="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $offer->description }}</textarea>
        </div>

        <div class="mb-4">
            <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Amount</label>
            <input type="number" id="amount" name="amount" value="{{ $offer->amount }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label for="deadline" class="block text-gray-700 text-sm font-bold mb-2">Deadline</label>
            <input type="date" id="deadline" name="deadline" value="{{ $offer->deadline }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Offer
            </button>
            <a href="{{ route('buying.dashboard') }}" class="inline-block align-baseline font-bold text-sm text-green-500 hover:text-green-800">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
