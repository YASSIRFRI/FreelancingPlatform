<div class="flex justify-between items-center bg-gray-100 p-4 shadow-md">
    <!-- Logo Text -->
    <div class="flex items-center">
        <span class="flex items-center text-2xl font-bold text-gray-800">
            Eza<span class="text-green-500 ml-1">.</span>
        </span>
        
        <!-- Desktop Navigation -->
        <nav class="hidden md:flex space-x-6 ml-8">
            <a href="{{ route('deposits.index') }}" class="text-gray-700 hover:text-green-500 font-semibold">Deposits</a>
            <a href="{{ route('withdrawals.index') }}" class="text-gray-700 hover:text-green-500 font-semibold">Withdrawals</a>
        </nav>
    </div>

    <!-- User Profile Section -->
    <div class="flex items-center space-x-4">
        <!-- User Avatar -->
        <div class="relative">
            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://via.placeholder.com/40' }}" alt="User Avatar" class="h-10 w-10 rounded-full cursor-pointer" id="profileDropdownToggle">

            <!-- Dropdown Menu -->
            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg py-2 z-10">
                <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Navigation -->
<nav class="md:hidden flex space-x-4 bg-gray-100 p-2 justify-center shadow-md">
    <a href="{{ route('deposits.index') }}" class="text-gray-700 hover:text-green-500 font-semibold">Deposits</a>
    
    <a href="{{ route('withdrawals.index') }}" class="text-gray-700 hover:text-green-500 font-semibold">Withdrawals</a>
</nav>

<script>
    // Toggle for the profile dropdown
    const profileDropdownToggle = document.getElementById('profileDropdownToggle');
    const profileDropdown = document.getElementById('profileDropdown');

    profileDropdownToggle.addEventListener('click', () => {
        profileDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', (event) => {
        if (!profileDropdownToggle.contains(event.target) && !profileDropdown.contains(event.target)) {
            profileDropdown.classList.add('hidden');
        }
    });
</script>
