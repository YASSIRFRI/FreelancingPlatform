<!-- resources/views/orders/create.blade.php -->

@extends('layouts.app')

@section('title', 'Order Service')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-green-400 text-3xl font-bold mb-6">Order Service</h1>
    <!-- Service Information -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="p-4">
            <h2 class="text-xl font-bold">{{ $service->name }}</h2>
            <p class="text-gray-600">{{ $service->description }}</p>
            <span class="text-green-600 font-semibold">GNC {{ number_format($service->price, 2) }}</span>
        </div>
    </div>

    <!-- Order Form -->
    <form id="orderForm" method="POST" action="{{ route('order.store', $service->id) }}">
        @csrf
        <div class="bg-white shadow-md rounded-lg overflow-hidden p-4">
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Order Description</label>
                <textarea id="description" name="description" rows="4" class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Add any additional details..."></textarea>
            </div>

            <button type="button" id="confirmOrderButton" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Order Now <i class="fas fa-check ml-2"></i> 
            </button>
        </div>
    </form>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold mb-4">Confirm Order</h3>
        <p>Are you sure you want to place this order?</p>
        <div class="mt-4 flex justify-end">
            <button id="cancelButton" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 mr-2">
                Cancel
            </button>
            <button id="confirmButton" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Confirm
            </button>
        </div>
    </div>
</div>

<script>
    document.getElementById('confirmOrderButton').addEventListener('click', function() {
        document.getElementById('confirmationModal').classList.remove('hidden');
    });

    document.getElementById('cancelButton').addEventListener('click', function() {
        document.getElementById('confirmationModal').classList.add('hidden');
    });

    document.getElementById('confirmButton').addEventListener('click', function() {
        document.getElementById('orderForm').submit();
    });
</script>
@endsection
