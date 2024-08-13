<!-- resources/views/admin/edit_content.blade.php -->

@extends('layouts.app')

@section('title', 'Edit Content')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-green-400 text-3xl font-bold mb-6">Edit Site Content</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.update_content') }}" method="POST">
        @csrf

        <!-- Terms and Conditions -->
        <div class="mb-4">
            <label for="terms_conditions" class="block text-sm font-medium text-gray-700">Terms and Conditions</label>
            <textarea name="terms_conditions" id="terms_conditions" rows="10" class="w-full border border-gray-300 rounded-md p-2">{{ Storage::disk('views')->get('terms_conditions.blade.php') }}</textarea>
        </div>

        <!-- Contact -->
        <div class="mb-4">
            <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
            <textarea name="contact" id="contact" rows="10" class="w-full border border-gray-300 rounded-md p-2">{{ Storage::disk('views')->get('contact.blade.php') }}</textarea>
        </div>

        <!-- How It Works -->
        <div class="mb-4">
            <label for="how_it_works" class="block text-sm font-medium text-gray-700">How It Works</label>
            <textarea name="how_it_works" id="how_it_works" rows="10" class="w-full border border-gray-300 rounded-md p-2">{{ Storage::disk('views')->get('how_it_works.blade.php') }}</textarea>
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Save Changes</button>
    </form>
</div>
@endsection
