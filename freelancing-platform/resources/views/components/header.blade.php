<div class="flex justify-between items-center bg-gray-100 p-4 shadow-md">
    <!-- Logo Text -->
    <div class="flex items-center">
        <span class="flex items-center text-2xl font-bold text-gray-800">
            Eza<span class="text-green-500 ml-1">.</span>
        </span>
        
        <!-- Desktop Navigation -->
        <nav class="hidden md:flex space-x-6 ml-8">
            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-green-500 font-semibold">Dashboard</a>
            <a href="{{ route('deposits.index') }}" class="text-gray-700 hover:text-green-500 font-semibold">Deposits</a>
            <a href="{{ route('withdrawals.index') }}" class="text-gray-700 hover:text-green-500 font-semibold">Withdrawals</a>
            <!--<a href="{{ route('services.index') }}" class="text-gray-700 hover:text-green-500 font-semibold">Services</a>-->
            <a href="{{ route('market.explore') }}" class="text-gray-700 hover:text-green-500 font-semibold">Find Sellers</a>
            <a href="#" class="text-gray-700 hover:text-green-500 font-semibold">Share my account</a>
        </nav>

        <!-- Mobile Toggle Button -->
        <button id="navToggle" class="md:hidden text-gray-700 ml-4">
            <i class="fas fa-bars fa-lg"></i>
        </button>
    </div>

    <!-- User Profile Section -->
    <div class="flex items-center space-x-4">
        <!-- Notifications -->
        <div class="relative">
            <button id="notificationsToggle" class="relative">
                <i class="fas fa-bell fa-lg text-gray-700"></i>
                @if($unreadNotifications > 0)
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                        {{ $unreadNotifications }}
                    </span>
                @endif
            </button>

            <!-- Notifications Dropdown -->
            <div id="notificationsDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-lg py-2 z-10">
                <h3 class="text-sm font-bold px-4 py-2 text-gray-700">Notifications</h3>
                <div class="max-h-48 overflow-y-auto">
                    @forelse ($notifications as $notification)
                        <div class="px-4 py-2 border-b border-gray-200 hover:bg-gray-100 cursor-pointer">
                            <p class="text-sm text-gray-600">{{ $notification->message }}</p>
                            <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-600 px-4 py-2">No new notifications</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- User Avatar -->
        <div class="relative">
            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : 'https://via.placeholder.com/40' }}" alt="User Avatar" class="h-10 w-10 rounded-full cursor-pointer" id="profileDropdownToggle">

            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg py-2 z-10">
                <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"><i class="fas fa-user fa-fw text-gray-700"></i> My Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-red-700 hover:bg-gray-100"><i class="fas fa-sign-out-alt fa-fw text-red-700"></i> Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Navigation -->
<nav id="mobileNav" class="hidden md:hidden flex flex-col space-y-4 bg-gray-100 p-4 shadow-md">
    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-green-500 font-semibold">Dashboard</a>
    <a href="{{ route('deposits.index') }}" class="text-gray-700 hover:text-green-500 font-semibold">Deposits</a>
    <a href="{{ route('withdrawals.index') }}" class="text-gray-700 hover:text-green-500 font-semibold">Withdrawals</a>
    <a href="{{ route('market.explore') }}" class="text-gray-700 hover:text-green-500 font-semibold">Find Sellers</a>
    <a href="#" class="text-gray-700 hover:text-green-500 font-semibold">Share my account</a>
</nav>

<script>
    // Toggle for the notifications dropdown
// Toggle for the notifications dropdown
    const notificationsToggle = document.getElementById('notificationsToggle');
    const notificationsDropdown = document.getElementById('notificationsDropdown');

    notificationsToggle.addEventListener('click', () => {
        notificationsDropdown.classList.toggle('hidden');

        fetch("{{ route('notifications.read-all') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            // Optionally, you can update the notification count here
            document.querySelector('#notificationsToggle .text-red-100').remove();
        })
        .catch(error => console.error('Error:', error));
    });

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

    // Toggle for the mobile navigation
    const navToggle = document.getElementById('navToggle');
    const mobileNav = document.getElementById('mobileNav');

    navToggle.addEventListener('click', () => {
        mobileNav.classList.toggle('hidden');
    });
</script>
