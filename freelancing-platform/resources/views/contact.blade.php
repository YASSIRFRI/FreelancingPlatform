@extends('layouts.guest')

@section('title', 'Terms and Conditions')

@section('content')

<div class="flex items-center justify-center min-h-screen mt-4">
    <div class="w-full">
        @php
            $howItWorksContent = Storage::get('contact.html');
        @endphp

        {!! $howItWorksContent !!}
    </div>
</div>



@endsection
