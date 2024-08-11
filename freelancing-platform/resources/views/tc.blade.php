@extends('layouts.guest')

@section('title', 'Terms and Conditions')

@section('content')
<div class="flex justify-between items-center bg-white mt-2 p-4 shadow-md">
    <!-- Logo Text -->
    <div class="flex items-center">
        <span class="flex items-center text-2xl font-bold text-gray-800">
            Eza<span class="text-green-500 ml-1">.</span>
        </span>
    </div>
</div>

<div class="flex items-center justify-center min-h-screen mt-4">
    <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-4xl">
        <div class="w-full p-8">
            <h1 class="text-3xl font-bold text-center mb-6">Terms and Conditions</h1>
            <p class="text-gray-600 mb-4">
                Welcome to Eza. Please read these Terms and Conditions ("Terms", "Terms and Conditions") carefully before using the Eza website (the "Service") operated by Eza ("us", "we", or "our").
            </p>

            <h2 class="text-xl font-semibold mb-4">1. Introduction</h2>
            <p class="text-gray-600 mb-4">
                By accessing or using our Service, you agree to be bound by these Terms. If you disagree with any part of the terms, then you do not have permission to access the Service.
            </p>

            <h2 class="text-xl font-semibold mb-4">2. Accounts</h2>
            <p class="text-gray-600 mb-4">
                When you create an account with us, you must provide us with accurate, complete, and current information. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account on our Service.
            </p>

            <h2 class="text-xl font-semibold mb-4">3. Purchases</h2>
            <p class="text-gray-600 mb-4">
                If you wish to purchase any product or service made available through the Service ("Purchase"), you may be asked to supply certain information relevant to your Purchase including, without limitation, your credit card number, the expiration date of your credit card, your billing address, and your shipping information.
            </p>

            <h2 class="text-xl font-semibold mb-4">4. Termination</h2>
            <p class="text-gray-600 mb-4">
                We may terminate or suspend access to our Service immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.
            </p>

            <h2 class="text-xl font-semibold mb-4">5. Changes</h2>
            <p class="text-gray-600 mb-4">
                We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material, we will try to provide at least 30 days' notice prior to any new terms taking effect.
            </p>
        </div>
    </div>
</div>
@endsection
