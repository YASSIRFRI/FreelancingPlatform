@extends('layouts.app')

@section('title', 'Withdrawals')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-green-300 text-3xl font-bold mb-6">Withdrawal Requests</h1>

    <!-- Success Message -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Withdrawals List -->
    <div class="space-y-4">
        @foreach ($withdrawals as $withdrawal)
            @php
                // Determine the color based on the state using if-else
                if ($withdrawal->state === 'completed') {
                    $color = 'border-green-500 bg-green-50 text-green-700';
                    $icon = 'check-circle';
                    $statusText = 'COMPLETED';
                } elseif ($withdrawal->state === 'pending') {
                    $color = 'border-yellow-500 bg-yellow-50 text-yellow-700';
                    $icon = 'clock';
                    $statusText = 'PENDING';
                } else {
                    $color = 'border-red-500 bg-red-50 text-red-700';
                    $icon = 'x-circle';
                    $statusText = 'REJECTED';
                }
            @endphp

            <div class="flex justify-between items-center border-l-4 {{ $color }} shadow-md rounded-lg p-4">
                <!-- Date -->
                <div class="flex items-center space-x-3">
                    <div class="text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-4 13h4m-8-8v5m0 0h8m0 0V3a1 1 0 00-1-1h-4a1 1 0 00-1 1v2a1 1 0 001 1h4v5" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-lg font-semibold">{{ $withdrawal->created_at->format('d M Y') }}</div>
                    </div>
                </div>

                <!-- Amount -->
                <div class="text-lg font-bold">{{ number_format($withdrawal->amount, 2) }} GHC</div>

                <!-- Status -->
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($icon == 'check-circle')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        @elseif($icon == 'clock')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l2 2m-2-2l-2 2" />
                        @endif
                    </svg>
                    <span class="text-lg font-semibold uppercase">
                        {{ ucfirst($withdrawal->state) }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    <!-- New Withdrawal Button -->
    <a href="{{ route('withdrawals.create') }}" class="mt-8 inline-block bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600 transition">
        New Withdrawal <i class="fas fa-plus-circle ml-1"></i>
    </a>
</div>
@endsection
