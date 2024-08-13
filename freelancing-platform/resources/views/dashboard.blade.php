@extends('layouts.app')

@section('title', 'Dashboard')

@section('username', $user->name)

@section('content')
<!-- Balance Summary -->
<div class="bg-white shadow rounded-lg p-6 mb-8 flex flex-col md:flex-row justify-between items-center">
    <div class="text-center mb-4 md:mb-0">
        <h3 class="text-2xl font-bold">Total Deposit</h3>
        <p class="text-green-500 text-xl font-semibold">GNC {{ number_format($user->deposits->sum('amount'), 2) }}</p>
    </div>
    <div class="w-24 h-24 relative flex items-center justify-center mb-4 md:mb-0">
        <canvas id="depositsBalanceChart" width="96" height="96"></canvas>
    </div>
    <div class="text-center">
        <h3 class="text-2xl font-bold">Current Balance</h3>
        <p class="text-green-500 text-xl font-semibold">GNC {{ number_format($user->balance, 2) }}</p>
    </div>
</div>

<!-- Navigation Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <a href="{{route('market.explore')}}" class="bg-white shadow rounded-lg p-6 flex flex-row md:flex-col items-center justify-center text-green-600 font-semibold text-xl transform transition-transform hover:scale-105 border border-green-500">
        <i class="fas fa-store fa-2x mb-2 md:mb-0 md:mr-2"></i>
        Market
    </a>

    <!-- Deposit Route -->
    <a href="{{ route('deposits.index') }}" class="bg-white shadow rounded-lg p-6 flex flex-row md:flex-col items-center justify-center text-green-600 font-semibold text-xl transform transition-transform hover:scale-105 border border-green-500">
        <i class="fas fa-wallet fa-2x mb-2 md:mb-0 md:mr-2"></i>
        Deposits
    </a>

    <!-- Withdrawal Route -->
    <a href="{{ route('withdrawals.index') }}" class="bg-white shadow rounded-lg p-6 flex flex-row md:flex-col items-center justify-center text-green-600 font-semibold text-xl transform transition-transform hover:scale-105 border border-green-500">
        <i class="fas fa-money-bill-wave fa-2x mb-2 md:mb-0 md:mr-2"></i>
        Withdrawals
    </a>

    <!-- My Profile Button -->
    <a href="{{ route('profile.index') }}" class="bg-white shadow rounded-lg p-6 flex flex-row md:flex-col items-center justify-center text-green-600 font-semibold text-xl transform transition-transform hover:scale-105 border border-green-500">
        <i class="fas fa-user fa-2x mb-2 md:mb-0 md:mr-2"></i>
        My Profile
    </a>

    <!-- Buying Button -->
    <a href="{{ route('buying.dashboard') }}" class="bg-white shadow rounded-lg p-6 flex flex-row md:flex-col items-center justify-center text-green-600 font-semibold text-xl transform transition-transform hover:scale-105 border border-green-500">
        <i class="fas fa-shopping-cart fa-2x mb-2 md:mb-0 md:mr-2"></i>
        Buying
    </a>

    <!-- Selling Button -->
    <a href="{{ route('selling.dashboard') }}" class="bg-white shadow rounded-lg p-6 flex flex-row md:flex-col items-center justify-center text-green-600 font-semibold text-xl transform transition-transform hover:scale-105 border border-green-500">
        <i class="fas fa-tags fa-2x mb-2 md:mb-0 md:mr-2"></i>
        Selling
    </a>

    <!-- How It Works Button -->
    <a href="{{route('htw')}}" class="bg-white shadow rounded-lg p-6 flex flex-row md:flex-col items-center justify-center text-green-600 font-semibold text-xl transform transition-transform hover:scale-105 border border-green-500">
        <i class="fas fa-info-circle fa-2x mb-2 md:mb-0 md:mr-2"></i>
        How It Works
    </a>

    <!-- Terms & Conditions and Privacy & Policy Button -->
    <a href="{{route('terms')}}" class="bg-white shadow rounded-lg p-6 flex flex-row md:flex-col items-center justify-center text-green-600 font-semibold text-xl transform transition-transform hover:scale-105 border border-green-500">
        <i class="fas fa-file-contract fa-2x mb-2 md:mb-0 md:mr-2"></i>
        T&C, P&P
    </a>

    <!-- Contact Us Button -->
    <a href="{{route('contact')}}" class="bg-white shadow rounded-lg p-6 flex flex-row md:flex-col items-center justify-center text-green-600 font-semibold text-xl transform transition-transform hover:scale-105 border border-green-500">
        <i class="fas fa-phone-alt fa-2x mb-2 md:mb-0 md:mr-2"></i>
        Contact Us
    </a>

    <!-- Market Button -->

</div>

<!-- Latest Orders -->
<div class="bg-white shadow rounded-lg p-6 mb-8">
    <h2 class="text-purple-600 text-2xl font-bold mb-4">Latest Orders <i class="fas fa-shopping-cart text-purple-500"></i>

    </h2>
    <ul class="space-y-4">
        @foreach ($latestOrders as $order)
        <li class="border-b border-gray-200 pb-2">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-purple-400 text-lg font-semibold">Order From : {{ $order->seller->name }}</h3>
                    <p class="text-gray-600">{{ $order->description }}</p>
                    @if($order->status=='completed')
                        <span class="text-green
                        -500 font-semibold">{{ ucfirst($order->status) }}</span>
                        @if($order->attachment)
                            <a href="{{ route('orders.download', $order->id) }}" class="text-purple-500 hover:text-green-700 transition">
                                <i class="fas fa-download"></i> <span class="sr-only">Download Attachments</span>
                            </a>
                        @endif
                    @else

                        <span class="text-red-500 font-semibold">{{ ucfirst($order->status) }}</span>
                    @endif
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-green-500 font-semibold">GNC{{ number_format($order->amount, 2) }}</span>
                    @if($order->attachment)
                        {{ route('orders.download', $order->id) }}" class="text-green-500 hover:text-green-700 transition">
                            <i class="fas fa-download"></i> <span class="sr-only">Download Attachments</span>
                        </a>
                    @endif
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>


<!-- Latest Deposits -->
<div class="bg-white shadow rounded-lg p-6 mb-8">
    <h2 class="text-green-700 text-2xl font-bold mb-4">Latest Deposits <i class="fas fa-wallet text-green-500"></i></h2>
    <ul class="space-y-4">
        @foreach ($latestDeposits as $deposit)
        <li class="border-b border-gray-200 pb-2">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg font-semibold">New Deposit</h3>
                    <p class="text-gray-600">{{ $deposit->created_at->format('M d, Y') }}</p>
                </div>
                <span class="text-green-500 font-semibold">GNC  {{ number_format($deposit->amount, 2) }}</span>
            </div>
        </li>
        @endforeach
    </ul>
</div>

<!-- Notifications -->  
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-red-800 text-2xl font-bold mb-4">Notifications <i class="fas fa-bell text-red-600"></i>

    </h2>
    <ul class="space-y-4">
        @foreach ($notifications as $notification)
        <li class="border-b border-gray-200 pb-2">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg font-semibold">{{ $notification->title }}</h3>
                    <p class="text-gray-600">{{ $notification->message }}</p>
                </div>
                <span class="text-gray-500 text-sm">{{ $notification->created_at->diffForHumans() }}</span>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('depositsBalanceChart').getContext('2d');
        var deposits = {{ $user->deposits->sum('amount') }};
        var balance = {{ $user->balance }};
        var total = deposits + balance;
        var depositsPercentage = (deposits / total) * 100;
        var balancePercentage = (balance / total) * 100;

        console.log('Deposits:', deposits, 'Balance:', balance, 'Total:', total);
        console.log('Deposits Percentage:', depositsPercentage, 'Balance Percentage:', balancePercentage);

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Deposits', 'Balance'],
                datasets: [{
                    data: [depositsPercentage, balancePercentage],
                    backgroundColor: ['#10B981', '#EF4444'], // green for deposits, red for balance
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                var label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw.toFixed(2) + '%';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
