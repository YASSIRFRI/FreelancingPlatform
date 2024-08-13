@extends('layouts.app')

@section('title', 'Buying Dashboard')

@section('username', $user->name)

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-100 shadow-md rounded-lg">
    <h1 class="text-4xl font-bold p-4 mb-8 text-green-500 flex items-center bg-white rounded shadow">
        <i class="fas fa-shopping-cart text-4xl text-green-500 mr-2"></i> Buyer Dashboard
    </h1>

    <!-- Offers Section -->
    <h2 class="text-3xl font-bold mb-6 text-green-700 flex items-center">
        <i class="fas fa-tags text-3xl text-green-500 mr-2"></i> Offers
    </h2>
    @foreach (['pending', 'approved', 'rejected'] as $status)
        <div class="mb-8">
            @php
                switch($status) {
                    case 'pending':
                        $statusColor = ' text-yellow-800';
                        $borderColor = 'border-yellow-300';
                        $statusIcon = 'fas fa-clock';
                        $statusTitle = 'Pending Offers';
                        break;
                    case 'approved':
                        $statusColor = ' text-green-800';
                        $borderColor = 'border-green-300';
                        $statusIcon = 'fas fa-check-circle';
                        $statusTitle = 'Approved Offers';
                        break;
                    case 'rejected':
                        $statusColor = ' text-red-800';
                        $borderColor = 'border-red-300';
                        $statusIcon = 'fas fa-times-circle';
                        $statusTitle = 'Rejected Offers';
                        break;
                    default:
                        $statusColor = ' text-gray-800';
                        $borderColor = 'border-gray-300';
                        $statusIcon = 'fas fa-info-circle';
                        $statusTitle = 'Unknown Status';
                        break;
                }
            @endphp
            <div class="bg-white shadow-md rounded-lg p-6 {{ $borderColor }} border-l-4">
                <h3 class="text-2xl font-bold mb-4 flex items-center {{ $statusColor }}">
                    <i class="{{ $statusIcon }} text-2xl mr-2"></i> {{ $statusTitle }}
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($offers->where('status', $status)->sortBy('created_at') as $offer)
                        <div class="bg-white border {{ $borderColor }} shadow rounded-lg p-4 transition-transform transform hover:scale-105">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-xl font-semibold {{ $statusColor }}">{{ $offer->description }}</h4>
                                <span class="text-green-500 font-semibold text-lg">GNC{{ number_format($offer->amount, 2) }}</span>
                            </div>
                            <div class="flex items-center mb-4">
                                <i class="{{ $statusIcon }} text-lg mr-2 {{ $statusColor }}"></i>
                                <span class="font-semibold text-md {{ $statusColor }}">{{ ucfirst($offer->status) }}</span>
                            </div>
                            <div class="flex space-x-4">
                                @if($offer->status == 'pending')
                                    <a href="{{ route('offers.edit', $offer->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                                        <i class="fas fa-edit mr-1"></i> Update
                                    </a>
                                    <form action="{{ route('offers.destroy', $offer->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                                            <i class="fas fa-trash mr-1"></i> Remove
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    <!-- Orders Section -->
<h2 class="text-3xl font-bold mb-6 mt-12 text-green-700 flex items-center">
    <i class="fas fa-box text-3xl text-green-500 mr-2"></i> Orders
</h2>
@foreach (['in-progress', 'completed', 'on-hold', 'cancelled'] as $status)
    <div class="mb-8">
        @php
            switch($status) {
                case 'in-progress':
                    $statusColor = ' text-blue-800';
                    $borderColor = 'border-blue-300';
                    $statusIcon = 'fas fa-spinner';
                    $statusTitle = 'In-Progress Orders';
                    break;
                case 'completed':
                    $statusColor = ' text-green-800';
                    $borderColor = 'border-green-300';
                    $statusIcon = 'fas fa-check-circle';
                    $statusTitle = 'Completed Orders';
                    break;
                case 'on-hold':
                    $statusColor = ' text-purple-800';
                    $borderColor = 'border-purple-300';
                    $statusIcon = 'fas fa-file-upload';
                    $statusTitle = 'On-Hold Orders';
                    break;
                case 'cancelled':
                    $statusColor = ' text-red-800';
                    $borderColor = 'border-red-300';
                    $statusIcon = 'fas fa-times-circle';
                    $statusTitle = 'Cancelled Orders';
                    break;
                default:
                    $statusColor = 'bg-gray-50 text-gray-800';
                    $borderColor = 'border-gray-300';
                    $statusIcon = 'fas fa-info-circle';
                    $statusTitle = 'Unknown Status';
                    break;
            }
        @endphp
        <div class="bg-white shadow-md rounded-lg p-6 {{ $borderColor }} border-l-4">
            <h3 class="text-2xl font-bold mb-4 flex items-center {{ $statusColor }}">
                <i class="{{ $statusIcon }} text-2xl mr-2"></i> {{ $statusTitle }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($orders->where('status', $status)->sortBy('created_at') as $order)
                    <div class="bg-white border {{ $borderColor }} shadow rounded-lg p-4 transition-transform transform hover:scale-105">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-xl font-semibold {{ $statusColor }}">{{ $order->description }}</h4>
                            <span class="text-green-500 font-semibold text-lg">GNC {{ number_format($order->amount, 2) }}</span>
                        </div>
                        <div class="flex items-center mb-4">
                            <i class="{{ $statusIcon }} text-lg mr-2 {{ $statusColor }}"></i>
                            <span class="font-semibold text-md {{ $statusColor }}">{{ ucfirst($order->status) }}</span>
                        </div>
                        @if($order->status == 'completed')
                            @if(is_null($order->review_id))
                                <!-- Button to Rate Seller -->
                                <div class="flex space-x-4">
                                    <a href="{{ route('reviews.create', $order->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                                        <i class="fas fa-star mr-1"></i> Rate Seller
                                    </a>
                                </div>
                            @else
                                <!-- Display Star Rating -->
                                <div class="flex items-center">
                                    @php
                                        $rating = $order->review->stars;
                                        $fullStars = floor($rating);
                                        $halfStar = ($rating - $fullStars) >= 0.5 ? true : false;
                                    @endphp

                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <i class="fas fa-star text-yellow-500"></i>
                                    @endfor

                                    @if ($halfStar)
                                        <i class="fas fa-star-half-alt text-yellow-500"></i>
                                    @endif

                                    @for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++)
                                        <i class="far fa-star text-yellow-500"></i>
                                    @endfor

                                    <span class="ml-2 text-gray-700">{{ round($rating, 2) }} / 5</span>
                                </div>
                            @endif
                        @endif
                        @if(in_array($order->status, ['on-hold', 'completed']))
                            <div class="flex space-x-4 mt-4">
                                <a href="{{ route('orders.download', $order->id) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                                    <i class="fas fa-download mr-1"></i> Download Attachments
                                </a>
                            </div>
                        @endif
                        @if($order->status == 'on-hold')
                            <div class="flex space-x-4 mt-4">
                                <form action="{{ route('orders.complete', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                                        <i class="fas fa-check mr-1"></i> Complete Order
                                    </button>
                                </form>
                                <button onclick="document.getElementById('revision-modal-{{ $order->id }}').classList.remove('hidden')" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                                    <i class="fas fa-exclamation-circle mr-1"></i> Request Revision
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endforeach
</div>


<!-- Revision Modals -->
@foreach ($orders as $order)
    <div id="revision-modal-{{ $order->id }}" class="hidden fixed z-50 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Request Revision</h3>
                            <div class="mt-2">
                                <form action="{{ route('orders.request-revision', $order->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="revision_request" class="block text-sm font-medium text-gray-700">Revision Request</label>
                                        <textarea name="revision_request" id="revision_request" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2" rows="4"></textarea>
                                        @error('revision_request')
                                            <div class="text-red-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition">
                                            Submit Revision Request
                                        </button>
                                        <button type="button" onclick="document.getElementById('revision-modal-{{ $order->id }}').classList.add('hidden')" class="ml-4 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
