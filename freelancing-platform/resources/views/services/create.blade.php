@extends('layouts.app')

@section('title', 'Create Service')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Create a New Service</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data" id="serviceForm">
            @csrf

            <!-- Service Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Service Name</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2">
                @error('name')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2" rows="4"></textarea>
                @error('description')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" step="0.01" name="price" id="price" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2">
                @error('price')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Service Image -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Service Image</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2">
                @error('image')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tags -->
            <div class="mb-4">
                <label for="tag" class="block text-sm font-medium text-gray-700">Tags</label>
                <div class="flex items-center">
                    <input type="text" id="tagInput" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2" placeholder="Enter a tag, e.g., 'Graphic Design'">
                    <button type="button" id="addTagButton" class="ml-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Add Tag</button>
                </div>
                <div id="tagsContainer" class="flex flex-wrap mt-2">
                    <!-- Tags will be appended here -->
                </div>
                <input type="hidden" name="tags" id="tagsHiddenInput">
                @error('tags')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                Create Service
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addTagButton = document.getElementById('addTagButton');
    const tagInput = document.getElementById('tagInput');
    const tagsContainer = document.getElementById('tagsContainer');
    const tagsHiddenInput = document.getElementById('tagsHiddenInput');
    
    let tags = [];

    addTagButton.addEventListener('click', function() {
        const tagValue = tagInput.value.trim();
        
        if (tagValue && !tags.includes(tagValue)) {
            tags.push(tagValue);
            updateTagsDisplay();
            tagInput.value = ''; // Clear the input
        }
    });

    function updateTagsDisplay() {
        tagsContainer.innerHTML = ''; // Clear current tags

        tags.forEach((tag, index) => {
            const tagElement = document.createElement('span');
            tagElement.classList.add('bg-gray-200', 'text-gray-800', 'px-3', 'py-1', 'rounded-full', 'mr-2', 'mb-2', 'flex', 'items-center');
            tagElement.innerHTML = `
                ${tag}
                <button type="button" class="ml-2 text-red-500 hover:text-red-700" data-tag-index="${index}">
                    <i class="fas fa-times"></i>
                </button>
            `;
            tagsContainer.appendChild(tagElement);
        });

        // Update hidden input with concatenated tags
        tagsHiddenInput.value = tags.join(',');
    }

    tagsContainer.addEventListener('click', function(event) {
        if (event.target.tagName === 'BUTTON' || event.target.closest('button')) {
            const button = event.target.closest('button');
            const tagIndex = button.getAttribute('data-tag-index');
            
            if (tagIndex !== null) {
                tags.splice(tagIndex, 1); // Remove the tag from the array
                updateTagsDisplay();
            }
        }
    });
});
</script>
@endsection
