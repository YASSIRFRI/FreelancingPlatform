<!-- resources/views/withdrawals/index.blade.php -->
@extends('layouts.app')

@section('title', 'Withdrawals')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">My Withdrawals</h1>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2">Date</th>
                <th class="py-2">Amount</th>
                <th class="py-2">State</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($withdrawals as $withdrawal)
                <tr>
                    <td class="py-2">{{ $withdrawal->date->format('Y-m-d') }}</td>
                    <td class="py-2">{{ $withdrawal->amount }}</td>
                    <td class="py-2">{{ ucfirst($withdrawal->state) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('withdrawals.create') }}" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded">
        New Withdrawal
    </a>
</div>
@endsection
