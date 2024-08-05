@extends('layouts.app')

@section('title', 'Dashboard')

@section('username', $user->name)

@section('content')
<!-- Balance Summary -->
<div class="bg-white shadow rounded-lg p-6 mb-8 flex justify-between items-center">
    <div class="text-center">
        <h3 class="text-2xl font-bold">Total Deposit</h3>
        <p class="text-green-500 text-xl font-semibold">$600.00</p>
    </div>
    <div class="w-24 h-24 relative flex items-center justify-center">
        <svg class="absolute inset-0" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
            <path
                class="text-gray-300"
                d="M18 2.0845
                a 15.9155 15.9155 0 0 1 0 31.831
                a 15.9155 15.9155 0 0 1 0 -31.831"
                fill="none"
                stroke-width="3"
                stroke="currentColor"
            />
            <path
                class="text-green-500"
                d="M18 2.0845
                a 15.9155 15.9155 0 0 1 0 31.831"
                fill="none"
                stroke-width="3"
                stroke-dasharray="50, 100"
                stroke="currentColor"
            />
        </svg>
    </div>
    <div class="text-center">
        <h3 class="text-2xl font-bold">Current Balance</h3>
        <p class="text-green-500 text-xl font-semibold">$200.00</p>
    </div>
</div>

<!-- Navigation Grid -->
<div class="grid grid-cols-3 gap-6 mb-8">
    <!-- Deposit Route -->
    <a href="{{ route('deposits.index') }}" class="bg-white shadow rounded-lg p-6 flex flex-col items-center justify-center text-green-600 font-semibold text-xl hover:bg-green-50 transition">
        <i class="fas fa-wallet fa-2x mb-2"></i>
        Deposits
    </a>

    <!-- Withdrawal Route -->
    <a href="{{ route('withdrawals.index') }}" class="bg-white shadow rounded-lg p-6 flex flex-col items-center justify-center text-green-600 font-semibold text-xl hover:bg-green-50 transition">
        <i class="fas fa-money-bill-wave fa-2x mb-2"></i>
        Withdrawals
    </a>

    <!-- My Profile Button -->
    <a href="{{ route('profile.index') }}" class="bg-white shadow rounded-lg p-6 flex flex-col items-center justify-center text-green-600 font-semibold text-xl hover:bg-green-50 transition">
        <i class="fas fa-user fa-2x mb-2"></i>
        My Profile
    </a>

    <!-- Buying Button -->
    <a href="#" class="bg-white shadow rounded-lg p-6 flex flex-col items-center justify-center text-green-600 font-semibold text-xl hover:bg-green-50 transition">
        <i class="fas fa-shopping-cart fa-2x mb-2"></i>
        Buying
    </a>

    <!-- Selling Button -->
    <a href="#" class="bg-white shadow rounded-lg p-6 flex flex-col items-center justify-center text-green-600 font-semibold text-xl hover:bg-green-50 transition">
        <i class="fas fa-tags fa-2x mb-2"></i>
        Selling
    </a>

    <!-- How It Works Button -->
    <a href="#" class="bg-white shadow rounded-lg p-6 flex flex-col items-center justify-center text-green-600 font-semibold text-xl hover:bg-green-50 transition">
        <i class="fas fa-info-circle fa-2x mb-2"></i>
        How It Works
    </a>

    <!-- Terms & Conditions and Privacy & Policy Button -->
    <a href="#" class="bg-white shadow rounded-lg p-6 flex flex-col items-center justify-center text-green-600 font-semibold text-xl hover:bg-green-50 transition">
        <i class="fas fa-file-contract fa-2x mb-2"></i>
        T&C, P&P
    </a>

    <!-- Contact Us Button -->
    <a href="#" class="bg-white shadow rounded-lg p-6 flex flex-col items-center justify-center text-green-600 font-semibold text-xl hover:bg-green-50 transition">
        <i class="fas fa-phone-alt fa-2x mb-2"></i>
        Contact Us
    </a>

    <!-- Market Button -->
    <a href="#" class="bg-white shadow rounded-lg p-6 flex flex-col items-center justify-center text-green-600 font-semibold text-xl hover:bg-green-50 transition">
        <i class="fas fa-store fa-2x mb-2"></i>
        Market
    </a>
</div>

<!-- Latest Orders -->
<div class="bg-white shadow rounded-lg p-6 mb-8">
    <h2 class="text-2xl font-bold mb-4">Latest Orders</h2>
    <ul class="space-y-4">
        @foreach ($latestOrders as $order)
        <li class="border-b border-gray-200 pb-2">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg font-semibold">{{ $order->service->name }}</h3>
                    <p class="text-gray-600">{{ $order->service->description }}</p>
                </div>
                <span class="text-green-500 font-semibold">${{ $order->amount }}</span>
            </div>
        </li>
        @endforeach
    </ul>
</div>

<!-- Latest Deposits -->
<div class="bg-white shadow rounded-lg p-6 mb-8">
    <h2 class="text-2xl font-bold mb-4">Latest Deposits</h2>
    <ul class="space-y-4">
        @foreach ($latestDeposits as $deposit)
        <li class="border-b border-gray-200 pb-2">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Deposit #{{ $deposit->id }}</h3>
                    <p class="text-gray-600">{{ $deposit->created_at->format('M d, Y') }}</p>
                </div>
                <span class="text-green-500 font-semibold">${{ $deposit->amount }}</span>
            </div>
        </li>
        @endforeach
    </ul>
</div>

<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Notifications</h2>
    <ul class="space-y-4">
        @foreach ($notifications as $notification)
        <li class="border-b border-gray-200 pb-2">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg font-semibold">{{ $notification->title }}</h3>
                    <p class="text-gray-600">{{ $notification->message }}</p>
                </div>
                <span class="text-gray-500 text-sm">{{ $notification->created_at->diffForHumans() }}</span>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection
