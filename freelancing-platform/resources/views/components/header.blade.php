<!-- resources/views/components/header.blade.php -->
<div class="flex justify-between items-center">
    <div class="flex items-center">
        <img src="https://via.placeholder.com/150" alt="User Avatar" class="h-12 w-12 rounded-full mr-3">
        <div class="flex flex-col">
            <h2 class="text-xl font-semibold">Welcome, @yield('username', 'User')</h2>
            <p class="text-gray-600">Your current balance: <span class="text-green-500 font-bold">GHC200.00</span></p>
        </div>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf <!-- This is essential for CSRF protection -->
        <button type="submit" class="flex items-center text-red-500 font-semibold">
            Logout
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
            </svg>
        </button>
    </form>
</div>
