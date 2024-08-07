@extends('layouts.app')

@section('title', 'Create Deposit')

@section('username', $user->name)

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Create a New Deposit</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('deposits.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" step="0.01" name="amount" id="amount" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2" placeholder="Enter amount in dollars">
                @error('amount')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                Submit Deposit
            </button>
        </form>
    </div>
</div>
@endsection
