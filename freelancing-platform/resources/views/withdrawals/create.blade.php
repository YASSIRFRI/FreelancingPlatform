<!-- resources/views/withdrawals/create.blade.php -->
@extends('layouts.app')

@section('title', 'New Withdrawal')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">New Withdrawal</h1>
    <form method="POST" action="{{ route('withdrawals.store') }}">
        @csrf
        <div class="mb-4">
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
            <input type="number" name="amount" id="amount" min="0.01" step="0.01" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2">
            @error('amount')
                <div class="text-red-500 mt-1">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Submit</button>
    </form>
</div>
@endsection
