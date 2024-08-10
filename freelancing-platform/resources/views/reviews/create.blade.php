@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-green-400 text-3xl font-bold mb-6">Review Order {{ $order->id }}</h1>

    <form action="{{ route('reviews.store', $order->id) }}" method="POST">
        @csrf
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Rating</label>
            <div id="star-rating" class="flex items-center space-x-2">
                @for ($i = 1; $i <= 5; $i++)
                    <i data-value="{{ $i }}" class="far fa-star text-3xl text-gray-400 cursor-pointer transition duration-300"></i>
                @endfor
            </div>
            <input type="hidden" name="stars" id="stars" value="0" required>
            @error('stars')
                <div class="text-red-500 mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Comment Section -->
        <div class="mb-6">
            <label for="comment" class="block text-gray-700 font-semibold mb-2">Comment</label>
            <textarea name="comment" id="comment" rows="5" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
            @error('comment')
                <div class="text-red-500 mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-300">
            Submit Review <i class="fas fa-check ml-2"></i>
        </button>
    </form>
</div>

<!-- Script for Interactive Star Rating -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('#star-rating i');
        const starInput = document.getElementById('stars');

        stars.forEach(star => {
            star.addEventListener('click', function () {
                const value = this.getAttribute('data-value');
                starInput.value = value;

                stars.forEach(s => {
                    s.classList.remove('fas');
                    s.classList.add('far');
                    s.classList.remove('text-yellow-500');
                    s.classList.add('text-gray-400');
                });

                for (let i = 0; i < value; i++) {
                    stars[i].classList.remove('far');
                    stars[i].classList.add('fas');
                    stars[i].classList.remove('text-gray-400');
                    stars[i].classList.add('text-yellow-500');
                }
            });
        });
    });
</script>
@endsection
