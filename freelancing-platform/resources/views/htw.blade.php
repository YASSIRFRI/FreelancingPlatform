@extends('layouts.guest')

@section('title', 'How It Works')

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
            <h1 class="text-3xl font-bold text-center mb-6">How It Works</h1>

            <h2 class="text-xl font-semibold mb-4">1. Overview</h2>
            <p class="text-gray-600 mb-4">
                Eza is designed to facilitate secure and seamless transactions between buyers and sellers. Whether you're purchasing goods or services, Eza ensures that both parties are protected throughout the process.
            </p>

            <h2 class="text-xl font-semibold mb-4">2. Fees</h2>
            <p class="text-gray-600 mb-4">
                Eza charges a nominal fee for each transaction to ensure the security and reliability of the platform. The fees are as follows:
            </p>
            <ul class="list-disc list-inside text-gray-600 mb-4">
                <li>Transaction Fee: 2% of the total amount</li>
                <li>Withdrawal Fee: $1 per withdrawal</li>
                <li>Deposit Fee: Free</li>
            </ul>
            <p class="text-gray-600 mb-4">
                Fees are automatically deducted from your balance at the time of the transaction.
            </p>

            <h2 class="text-xl font-semibold mb-4">3. Return Policy</h2>
            <p class="text-gray-600 mb-4">
                We understand that sometimes things don’t go as planned. If you are not satisfied with a product or service, you may be eligible for a return or refund under the following conditions:
            </p>
            <ul class="list-disc list-inside text-gray-600 mb-4">
                <li>Requests for returns or refunds must be made within 14 days of receiving the product or service.</li>
                <li>The product must be in its original condition and packaging.</li>
                <li>For services, refunds will only be processed if the service was not delivered as agreed.</li>
            </ul>
            <p class="text-gray-600 mb-4">
                To initiate a return or refund, please contact our support team with your order details and the reason for the return.
            </p>

            <h2 class="text-xl font-semibold mb-4">4. User Verification</h2>
            <p class="text-gray-600 mb-4">
                At Eza, we prioritize the security and trust of our users. To ensure that all users are genuine, we require verification during the registration process. Verified users enjoy additional benefits such as:
            </p>
            <ul class="list-disc list-inside text-gray-600 mb-4">
                <li>Increased transaction limits</li>
                <li>Priority customer support</li>
                <li>Access to premium features</li>
            </ul>
            <p class="text-gray-600 mb-4">
                Verification is simple and can be completed in just a few steps. You will need to provide a valid government-issued ID and proof of address.
            </p>

            <h2 class="text-xl font-semibold mb-4">5. Dispute Resolution</h2>
            <p class="text-gray-600 mb-4">
                In the event of a dispute between a buyer and a seller, Eza offers a dispute resolution service. Our team will review the case and work with both parties to reach a fair resolution. Disputes must be filed within 30 days of the transaction.
            </p>

            <h2 class="text-xl font-semibold mb-4">6. Security</h2>
            <p class="text-gray-600 mb-4">
                Security is our top priority. Eza uses industry-standard encryption and security protocols to protect your information. We also continuously monitor our platform for any suspicious activity and take immediate action to protect our users.
            </p>

            <h2 class="text-xl font-semibold mb-4">7. Support</h2>
            <p class="text-gray-600 mb-4">
                Our support team is here to help you with any questions or issues you may have. You can reach us via email, phone, or live chat. We strive to respond to all inquiries within 24 hours.
            </p>
        </div>
    </div>
</div>
@endsection
