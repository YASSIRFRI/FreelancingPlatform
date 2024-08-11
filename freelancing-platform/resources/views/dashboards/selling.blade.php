@extends('layouts.app')

@section('title', 'Seller Dashboard')

@section('username', $user->name)

@section('content')
    <h1 class="text-4xl font-bold p-4 mb-8 text-green-500 flex items-center">
        <i class="fas fa-store text-4xl text-green-500 mr-2"></i> Seller Dashboard
    </h1>
<div class="container mx-auto px-4 py-8 bg-gray-100 shadow-md rounded-lg">

    <!-- Offers Section -->
    <h2 class="text-3xl font-bold mb-6 text-green-700 flex items-center">
        <i class="fas fa-tags text-3xl text-green-500 mr-2"></i> Offers
    </h2>
    @foreach (['pending', 'approved', 'rejected'] as $status)
        <div class="mb-8">
            @php
                switch($status) {
                    case 'pending':
                        $statusColor = 'bg-yellow-50 text-yellow-800';
                        $borderColor = 'border-yellow-300';
                        $statusIcon = 'fas fa-clock';
                        $statusTitle = 'Pending Offers';
                        break;
                    case 'approved':
                        $statusColor = 'bg-green-50 text-green-800';
                        $borderColor = 'border-green-300';
                        $statusIcon = 'fas fa-check-circle';
                        $statusTitle = 'Approved Offers';
                        break;
                    case 'rejected':
                        $statusColor = 'bg-red-50 text-red-800';
                        $borderColor = 'border-red-300';
                        $statusIcon = 'fas fa-times-circle';
                        $statusTitle = 'Rejected Offers';
                        break;
                    default:
                        $statusColor = 'bg-gray-50 text-gray-800';
                        $borderColor = 'border-gray-300';
                        $statusIcon = 'fas fa-info-circle';
                        $statusTitle = 'Unknown Status';
                        break;
                }
            @endphp
            <div class="bg-white shadow-md rounded-lg p-6 {{ $borderColor }} border-l-4">
                <h3 class="text-2xl font-bold mb-4 flex items-center {{ $statusColor }}">
                    <i class="{{ $statusIcon }} text-2xl mr-2"></i> {{ $statusTitle }}
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($offers->where('status', $status)->sortBy('created_at') as $offer)
                        <div class="bg-white border {{ $borderColor }} shadow rounded-lg p-4 transition-transform transform hover:scale-105">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-xl font-semibold {{ $statusColor }}">{{ $offer->description }}</h4>
                                <span class="text-green-500 font-semibold text-lg">${{ number_format($offer->amount, 2) }}</span>
                            </div>
                            <div class="flex items-center mb-4">
                                <i class="{{ $statusIcon }} text-lg mr-2 {{ $statusColor }}"></i>
                                <span class="font-semibold text-md {{ $statusColor }}">{{ ucfirst($offer->status) }}</span>
                            </div>
                            <div class="flex space-x-4">
                                @if($offer->status == 'pending')
                                    <form action="{{ route('offers.approve', $offer->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                                            <i class="fas fa-check mr-1"></i> Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('offers.reject', $offer->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                                            <i class="fas fa-times mr-1"></i> Reject
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <!-- Orders Section -->
    <h2 class="text-3xl font-bold mb-6 mt-12 text-green-700 flex items-center">
        <i class="fas fa-box text-3xl text-green-500 mr-2"></i> Orders
    </h2>
    @foreach (['in-progress', 'on-hold', 'completed', 'cancelled'] as $status)
        <div class="mb-8">
            @php
                switch($status) {
                    case 'in-progress':
                        $statusColor = 'bg-blue-50 text-blue-800';
                        $borderColor = 'border-blue-300';
                        $statusIcon = 'fas fa-spinner';
                        $statusTitle = 'In-Progress Orders';
                        break;
                    case 'on-hold':
                        $statusColor = 'bg-yellow-50 text-yellow-800';
                        $borderColor = 'border-yellow-300';
                        $statusIcon = 'fas fa-pause-circle';
                        $statusTitle = 'On-Hold Orders';
                        break;
                    case 'completed':
                        $statusColor = 'bg-green-50 text-green-800';
                        $borderColor = 'border-green-300';
                        $statusIcon = 'fas fa-check-circle';
                        $statusTitle = 'Completed Orders';
                        break;
                    case 'cancelled':
                        $statusColor = 'bg-red-50 text-red-800';
                        $borderColor = 'border-red-300';
                        $statusIcon = 'fas fa-times-circle';
                        $statusTitle = 'Cancelled Orders';
                        break;
                    default:
                        $statusColor = 'bg-gray-50 text-gray-800';
                        $borderColor = 'border-gray-300';
                        $statusIcon = 'fas fa-info-circle';
                        $statusTitle = 'Unknown Status';
                        break;
                }
            @endphp
            <div class="bg-white shadow-md rounded-lg p-6 {{ $borderColor }} border-l-4">
                <h3 class="text-2xl font-bold mb-4 flex items-center {{ $statusColor }}">
                    <i class="{{ $statusIcon }} text-2xl mr-2"></i> {{ $statusTitle }}
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($orders->where('status', $status)->sortBy('created_at') as $order)
                        <div class="bg-white border {{ $borderColor }} shadow rounded-lg p-4 transition-transform transform hover:scale-105">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-xl font-semibold {{ $statusColor }}">{{ $order->description }}</h4>
                                <span class="text-green-500 font-semibold text-lg">${{ number_format($order->amount, 2) }}</span>
                            </div>
                            <div class="mb-4">
                                <span class="text-sm text-gray-600">Fee: ${{ number_format($order->fee, 2) }}</span>
                            </div>
                            @if($order->status == 'completed')
                                <div class="mb-4">
                                    <span class="text-sm text-gray-600">Earnings: ${{ number_format($order->amount - $order->fee, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex items-center mb-4">
                                <i class="{{ $statusIcon }} text-lg mr-2 {{ $statusColor }}"></i>
                                <span class="font-semibold text-md {{ $statusColor }}">{{ ucfirst($order->status) }}</span>
                            </div>
                            @if($order->status == 'in-progress')
                                <div class="flex justify-end">
                                    <a href="{{ route('orders.submit', $order->id) }}" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 transition">
                                        <i class="fas fa-check mr-1"></i> Deliver Now
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
