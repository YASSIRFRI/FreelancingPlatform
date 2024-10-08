<!-- resources/views/components/dashboard-button.blade.php -->
@props(['href' => '#'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'bg-white shadow rounded-lg p-4 flex items-center justify-center text-green-600 font-semibold hover:bg-green-100 transition']) }}>
    {{ $slot }}
</a>
