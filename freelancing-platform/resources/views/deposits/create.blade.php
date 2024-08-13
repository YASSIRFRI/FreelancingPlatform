@extends('layouts.app')

@section('title', 'Create Deposit')

@section('username', $user->name)

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Create a New Deposit</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
            @csrf

            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" step="0.01" name="amount" id="amount" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2" placeholder="Enter amount in GNC">
                @error('amount')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <input type="hidden" name="email" value="{{ $user->email }}"> {{-- required --}}
            <input type="hidden" name="orderID" value="{{ uniqid() }}">
            <input type="hidden" name="currency" value="GHS">
            <input type="hidden" name="metadata" value="{{ json_encode($array = ['key_name' => 'value']) }}" > {{-- For other necessary things you want to add to your payload. It is optional though --}}
            <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                Pay Now
            </button>
        </form>
    </div>
</div>
@endsection
