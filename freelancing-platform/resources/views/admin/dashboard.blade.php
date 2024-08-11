@extends('layouts.app')

@section('title', 'user Dashboard')

@section('username', $user->username)

@section('content')
<!-- Earnings Summary -->
<div class="bg-white shadow rounded-lg p-6 mb-8 flex flex-col md:flex-row justify-between items-center">
    <div class="text-center mb-4 md:mb-0">
        <h3 class="text-2xl font-bold">Today's Earnings</h3>
        <p class="text-green-500 text-xl font-semibold">${{ number_format($todaysEarnings, 2) }}</p>
    </div>
    <div class="text-center">
        <h3 class="text-2xl font-bold">Overall Earnings</h3>
        <p class="text-green-500 text-xl font-semibold">${{ number_format($overallEarnings, 2) }}</p>
    </div>
</div>

<!-- Verification Requests -->
<div class="bg-white shadow rounded-lg p-6 mb-8">
    <h2 class="text-blue-600 text-2xl font-bold mb-4">Verification Requests <i class="fas fa-user-check text-blue-500"></i></h2>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b border-gray-200 text-left">User</th>
                <th class="py-2 px-4 border-b border-gray-200 text-left">Email</th>
                <th class="py-2 px-4 border-b border-gray-200 text-left">Requested At</th>
                <th class="py-2 px-4 border-b border-gray-200 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($verificationRequests as $request)
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $request->user->name }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $request->user->email }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $request->created_at->format('M d, Y H:i') }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">
                        <form action="{{ route('admin.verify', $request->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Approve</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Latest Orders -->
<div class="bg-white shadow rounded-lg p-6 mb-8">
    <h2 class="text-purple-600 text-2xl font-bold mb-4">Recent Orders <i class="fas fa-shopping-cart text-purple-500"></i></h2>
    <ul class="space-y-4">
        @foreach ($recentOrders as $order)
        <li class="border-b border-gray-200 pb-2">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-purple-400 text-lg font-semibold">Order From : {{ $order->seller->name }}</h3>
                    <p class="text-gray-600">{{ $order->description }}</p>
                    @if($order->status == 'completed')
                        <span class="text-green-500 font-semibold">{{ ucfirst($order->status) }}</span>
                        @if($order->attachment)
                            <a href="{{ route('orders.download', $order->id) }}" class="text-purple-500 hover:text-green-700 transition">
                                <i class="fas fa-download"></i> <span class="sr-only">Download Attachments</span>
                            </a>
                        @endif
                    @else
                        <span class="text-red-500 font-semibold">{{ ucfirst($order->status) }}</span>
                    @endif
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-green-500 font-semibold">${{ number_format($order->amount, 2) }}</span>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection
