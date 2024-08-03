<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard')

@section('username', 'Sampson Okyere')

@section('content')
<div class="bg-white shadow rounded-lg p-4 mb-6 flex justify-between items-center">
    <div class="text-center">
        <h3 class="text-lg font-bold">Total Deposit</h3>
        <p class="text-green-500 font-semibold">GHC600.00</p>
    </div>
    <div class="w-16 h-16 relative">
        <svg class="absolute top-0 left-0" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
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
        <h3 class="text-lg font-bold">Current Balance</h3>
        <p class="text-green-500 font-semibold">GHC200.00</p>
    </div>
</div>

<div class="grid grid-cols-2 gap-4">
    <!-- Deposit Route -->
    <x-dashboard-button :href="route('deposits.index')">
        <i class="fas fa-wallet mr-2"></i>Deposits
    </x-dashboard-button>

    <!-- Withdrawal Route -->
    <x-dashboard-button :href="route('withdrawals.index')">
        <i class="fas fa-money-bill-wave mr-2"></i>Withdrawals
    </x-dashboard-button>

    <!-- My Profile Button (No route specified) -->
    <x-dashboard-button href="#">
        <i class="fas fa-user mr-2"></i>My Profile
    </x-dashboard-button>

    <!-- Buying Button (No route specified) -->
    <x-dashboard-button href="#">
        <i class="fas fa-shopping-cart mr-2"></i>Buying
    </x-dashboard-button>

    <!-- Selling Button (No route specified) -->
    <x-dashboard-button href="#">
        <i class="fas fa-tags mr-2"></i>Selling
    </x-dashboard-button>

    <!-- How It Works Button (No route specified) -->
    <x-dashboard-button href="#">
        <i class="fas fa-info-circle mr-2"></i>How It Works
    </x-dashboard-button>

    <!-- Terms & Conditions and Privacy & Policy Button (No route specified) -->
    <x-dashboard-button href="#">
        <i class="fas fa-file-contract mr-2"></i>T&C, P&P
    </x-dashboard-button>

    <!-- Contact Us Button (No route specified) -->
    <x-dashboard-button href="#">
        <i class="fas fa-phone-alt mr-2"></i>Contact Us
    </x-dashboard-button>

    <!-- Market Button (No route specified) -->
    <x-dashboard-button href="#">
        <i class="fas fa-store mr-2"></i>Market
    </x-dashboard-button>
</div>
@endsection
