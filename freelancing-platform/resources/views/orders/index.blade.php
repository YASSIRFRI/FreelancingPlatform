@extends('layouts.app')

@section('title', 'My Orders')

@section('username', $user->name)

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">My Selling Orders</h1>

    <!-- Orders Table -->
    <div class="bg-white shadow rounded-lg p-6 mb-8">
        @if($orders->count())
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 border-b">Order ID</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 border-b">Service Name</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 border-b">Buyer</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 border-b">Amount</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 border-b">Status</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr class="border-b">
                        <td class="py-3 px-4 text-sm text-gray-900">{{ $order->id }}</td>
                        <td class="py-3 px-4 text-sm text-gray-900">{{ $order->service->name }}</td>
                        <td class="py-3 px-4 text-sm text-gray-900">{{ $order->buyer->name }}</td>
                        <td class="py-3 px-4 text-sm text-gray-900">GHC {{ number_format($order->amount, 2) }}</td>
                        <td class="py-3 px-4 text-sm text-gray-900">{{ ucfirst($order->status) }}</td>
                        <td class="py-3 px-4 text-sm text-gray-900">
                            <a href="{{ route('orders.show', $order->id) }}" class="text-green-600 hover:text-green-800">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center text-gray-600">
                <p>No orders found.</p>
            </div>
        @endif
    </div>
</div>
@endsection
