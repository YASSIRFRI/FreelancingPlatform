<!-- resources/views/deposits/index.blade.php -->
@extends('layouts.app')

@section('title', 'Deposits')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">My Deposits</h1>
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
            <!-- Manually added dummy data -->
            <tr>
                <td class="py-2">2024-08-01</td>
                <td class="py-2">$1,000.00</td>
                <td class="py-2">Completed</td>
            </tr>
            <tr>
                <td class="py-2">2024-08-02</td>
                <td class="py-2">$500.00</td>
                <td class="py-2">Pending</td>
            </tr>
            <tr>
                <td class="py-2">2024-08-03</td>
                <td class="py-2">$750.00</td>
                <td class="py-2">Failed</td>
            </tr>
            <tr>
                <td class="py-2">2024-08-04</td>
                <td class="py-2">$1,250.00</td>
                <td class="py-2">Completed</td>
            </tr>
            <!-- Add more dummy data as needed -->
        </tbody>
    </table>
    <a href="{{ route('deposits.create') }}" class="mt-4 inline-block bg-green-500 text-white px-4 py-2 rounded">
       
