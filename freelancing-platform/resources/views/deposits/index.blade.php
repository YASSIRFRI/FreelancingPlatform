@extends('layouts.app')

@section('title', 'My Deposits')

@section('username', $user->name)

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">My Deposits</h1>


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
                    <tr class="border-b">
                        <td class="py-3 px-4 text-sm text-gray-900">{{ $deposit->id }}</td>
                        <td class="py-3 px-4 text-sm text-gray-900">${{ number_format($deposit->amount, 2) }}</td>
                        <td class="py-3 px-4 text-sm text-gray-900">{{ $deposit->created_at->format('M d, Y') }}</td>
                        <td class="py-3 px-4 text-sm text-gray-900">{{ ucfirst($deposit->status) }}</td>
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
    <!-- Button to Create New Deposit -->
    <div class="mb-4">
        <a href="{{ route('deposits.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
            Create New Deposit
        </a>
    </div>
    </div>
</div>
@endsection
