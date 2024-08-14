@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="flex justify-between items-center bg-white mt-2 p-4 shadow-md">
    <!-- Logo Text -->
    <div class="flex items-center">
        <span class="flex items-center text-2xl font-bold text-gray-800">
            Eza<span class="text-green-500 ml-1">.</span>
        </span>
    </div>
</div>

<div class="flex items-center justify-center min-h-screen">
    <div class="flex flex-col sm:flex-row items-between bg-white shadow-md rounded-lg p-8 max-w-4xl">
        <!-- Right Side with Login Form (will appear first on mobile) -->
        <div class="w-full sm:w-1/2 p-8 flex justify-center items-center order-2 sm:order-1">
            <div class="max-w-sm w-full">
                <h1 class="text-2xl font-bold text-center mb-6">LOGIN</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" required autofocus class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2">
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2">
                    </div>
                    <div class="flex items-center justify-between">
                        <a href="#" class="text-sm text-green-600 hover:text-green-500">Forgot password?</a>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            LOGIN
                        </button>
                    </div>
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="font-medium text-green-600 hover:text-green-500">Sign up</a></p>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
