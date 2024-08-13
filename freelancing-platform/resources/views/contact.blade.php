@extends('layouts.guest')

@section('title', 'Contact Us')

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
            @php
                try {
                    $contactContent = Storage::get('contact.html');
                } catch (\Exception $e) {
                    $contactContent = '<p class="text-red-500">Sorry, the contact information could not be loaded at this time.</p>';
                }
            @endphp

            {!! $contactContent !!}
            
            <!-- Contact Form -->
            <h2 class="text-xl font-semibold mb-4">3. Send Us a Message</h2>
            <p class="text-gray-600 mb-4">
                If you prefer, you can use the form below to send us a message directly. We strive to respond to all inquiries within 24 hours.
            </p>
            <form method="POST" action="{{ route('contact.submit') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2">
                </div>
                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                    <input type="text" name="subject" id="subject" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2">
                </div>
                <div class="mb-6">
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea name="message" id="message" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2"></textarea>
                </div>
                <div class="mt-6">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
