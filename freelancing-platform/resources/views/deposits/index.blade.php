@extends('layouts.app')

@section('title', 'My Deposits')

@section('username', $user->name)

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-green-300 text-3xl font-bold mb-6">My Deposits</h1>

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

    <!-- Deposits Table -->
    <div class="bg-white shadow rounded-lg p-6">
        @if($deposits->count())
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 border-b">Deposit ID</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 border-b">Amount</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 border-b">Date</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deposits as $deposit)
                        @php
                            // Determine the color based on the status using if-else
                            if ($deposit->status === 'complete') {
                                $color = 'text-green-700';
                            } elseif ($deposit->status === 'pending') {
                                $color = 'text-yellow-700';
                            } else {
                                $color = 'text-red-700';
                            }
                        @endphp
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-4 text-sm text-gray-900">{{ $deposit->id }}</td>
                            <td class="py-3 px-4 text-sm text-gray-900">{{ number_format($deposit->amount, 2) }} GHC</td>
                            <td class="py-3 px-4 text-sm text-gray-900">{{ $deposit->created_at->format('M d, Y') }}</td>
                            <td class="py-3 px-4 text-sm {{ $color }} font-semibold uppercase">{{ ucfirst($deposit->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $deposits->links() }}
            </div>
        @else
            <div class="text-center text-gray-600">
                <p>No deposits found.</p>
            </div>
        @endif
    </div>

    <!-- Button to Create New Deposit -->
    <div class="mt-8">
        <a href="{{ route('deposits.create') }}" class="inline-block bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600 transition">
            Create New Deposit <i class="fas fa-plus-circle ml-1"></i>
        </a>
    </div>
</div>
@endsection
