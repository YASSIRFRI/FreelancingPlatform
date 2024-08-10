@extends('layouts.app')

@section('title', 'Submit Order')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Submit Your Work for <span class="text-green-500">{{ $order->id }}</span></h1>

    <div class="bg-white p-6 shadow-md rounded-lg">
        <form action="{{ route('orders.storeSubmission', $order->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm p-2" rows="4"></textarea>
                @error('description')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>
            <!-- Attachments -->
            <div class="mb-4">
                <label for="attachments" class="block text-sm font-medium text-gray-700">Attachments</label>
                <div id="attachment-container" class="space-y-2">
                    <div class="flex items-center">
                        <input type="file" name="attachments[]" class="file-input" onchange="previewFiles(this)">
                        <button type="button" class="ml-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition" onclick="addAttachmentInput()">
                            Add Attachment <i class="fas fa-plus ml-2"></i>
                        </button>
                    </div>
                </div>
                @error('attachments.*')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Preview Container -->
            <div id="preview-container" class="mb-4 flex flex-wrap space-x-4">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                Submit Order <i class="fas fa-check ml-2"></i>
            </button>
        </form>
    </div>
</div>

<script>
    function addAttachmentInput() {
        const container = document.getElementById('attachment-container');
        const inputDiv = document.createElement('div');
        inputDiv.classList.add('flex', 'items-center', 'mt-2');

        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'attachments[]';
        input.classList.add('file-input');
        input.onchange = function() { previewFiles(this) };

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('ml-2', 'bg-red-500', 'text-white', 'px-4', 'py-2', 'rounded', 'hover:bg-red-600', 'transition');
        removeButton.innerText = 'Remove';
        removeButton.onclick = function() { container.removeChild(inputDiv) };

        inputDiv.appendChild(input);
        inputDiv.appendChild(removeButton);
        container.appendChild(inputDiv);
    }

    function previewFiles(input) {
        const previewContainer = document.getElementById('preview-container');
        const files = input.files;

        for (const file of files) {
            const reader = new FileReader();

            reader.onload = (e) => {
                const previewDiv = document.createElement('div');
                previewDiv.classList.add('w-24', 'h-24', 'relative', 'border', 'border-gray-300', 'rounded', 'overflow-hidden', 'mb-2');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = file.name;
                img.classList.add('w-full', 'h-full', 'object-cover');

                previewDiv.appendChild(img);
                previewContainer.appendChild(previewDiv);
            };

            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
