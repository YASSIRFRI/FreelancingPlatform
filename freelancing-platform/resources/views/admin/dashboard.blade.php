@extends('layouts.app')

@section('title', 'Admin Dashboard')

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
                <th class="py-2 px-4 border-b border-gray-200 text-left">Documents</th>
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
                        <a href="{{ Storage::url($request->verification_paper) }}" class="text-blue-500 hover:text-blue-700 transition">
                            <i class="fas fa-download"></i> ID Paper
                        </a>
                        <a href="{{ Storage::url($request->verification_image) }}" class="text-blue-500 hover:text-blue-700 transition ml-4">
                            <i class="fas fa-download"></i> ID Image
                        </a>
                    </td>
                    <td class="py-2 px-4 border-b border-gray-200">
                        <div class="flex space-x-4">
                            <form action="{{ route('admin.verify', $request->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Approve</button>
                            </form>
                            <form action="{{ route('admin.deny_verification', $request->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Deny</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Withdrawal Requests -->
<div class="bg-white shadow rounded-lg p-6 mb-8">
    <h2 class="text-green-600 text-2xl font-bold mb-4">Withdrawal Requests <i class="fas fa-money-check-alt text-green-500"></i></h2>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b border-gray-200 text-left">User</th>
                <th class="py-2 px-4 border-b border-gray-200 text-left">Amount</th>
                <th class="py-2 px-4 border-b border-gray-200 text-left">Requested At</th>
                <th class="py-2 px-4 border-b border-gray-200 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($withdrawalRequests as $request)
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $request->user->name }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">${{ number_format($request->amount, 2) }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $request->created_at->format('M d, Y H:i') }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">
                        <div class="flex space-x-4">
                            <form action="{{ route('admin.withdrawals.approve', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Approve</button>
                            </form>
                            <form action="{{ route('admin.withdrawals.deny', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Deny</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Users Management -->
<div class="bg-white shadow rounded-lg p-6 mb-8">
    <h2 class="text-purple-600 text-2xl font-bold mb-4">User Management <i class="fas fa-users text-purple-500"></i></h2>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b border-gray-200 text-left">User</th>
                <th class="py-2 px-4 border-b border-gray-200 text-left">Email</th>
                <th class="py-2 px-4 border-b border-gray-200 text-left">Verification Status</th>
                <th class="py-2 px-4 border-b border-gray-200 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $user->email }}</td>

                    <td class="py-2 px-4 border-b border-gray-200">
                        @if ($user->verified)
                            <span class="text-green-500 font-semibold">Verified</span>
                        @else
                            <span class="text-red-500 font-semibold">Not Verified</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b border-gray-200">
                        @if ($user->verified)
                            <form action="{{ route('admin.unverify_user', $user->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Unverify</button>
                            </form>
                        @else
                            <span class="text-gray-500">No Action Needed</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Fee Management -->
<div class="bg-white shadow rounded-lg p-6 mb-8">
    <h2 class="text-yellow-600 text-2xl font-bold mb-4">Fee Management <i class="fas fa-percentage text-yellow-500"></i></h2>
    <form action="{{ route('admin.update_fees') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="BUYER_FEE" class="block text-sm font-medium text-gray-700">Buyer Fee (%)</label>
            <input type="text" name="BUYER_FEE" id="BUYER_FEE" value="{{ config('app.buyer_fee') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
        </div>
        <div class="mb-4">
            <label for="SELLER_FEE" class="block text-sm font-medium text-gray-700">Seller Fee (%)</label>
            <input type="text" name="SELLER_FEE" id="SELLER_FEE" value="{{ config('app.seller_fee') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
        </div>
        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">Update Fees <i class="fas fa-save ml-2"></i></button>
    </form>
</div>

<!-- Content Management -->
<div class="bg-white shadow rounded-lg p-6 mb-8">
    <h2 class="text-red-600 text-2xl font-bold mb-4">Content Management <i class="fas fa-edit text-red-500"></i></h2>

    <form action="{{ route('admin.update_content') }}" method="POST">
        @csrf

        <!-- Terms and Conditions -->
        <div class="mb-4">
            <label for="terms_conditions" class="block text-sm font-medium text-gray-700">Terms and Conditions (HTML)</label>
            <textarea id="terms_conditions" name="terms_conditions" rows="6" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" required>{{ $termsConditionsContent }}</textarea>
        </div>

        <!-- Contact -->
        <div class="mb-4">
            <label for="contact" class="block text-sm font-medium text-gray-700">Contact (HTML)</label>
            <textarea id="contact" name="contact" rows="6" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" required>{{ $contactContent }}</textarea>
        </div>

        <!-- How It Works -->
        <div class="mb-4">
            <label for="how_it_works" class="block text-sm font-medium text-gray-700">How It Works (HTML)</label>
            <textarea id="how_it_works" name="how_it_works" rows="6" class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" required>{{ $howItWorksContent }}</textarea>
        </div>

        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Update Content <i class="fas fa-save ml-2"></i></button>
    </form>
</div>
@endsection
