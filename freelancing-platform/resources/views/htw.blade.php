@extends('layouts.guest')

@section('title', 'terms and Conditions')

@section('content')

<div class="flex items-center justify-center min-h-screen mt-2">
        <div class="w-full">
            @php
                $howItWorksContent = Storage::get('how_it_works.html');
            @endphp

            {!! $howItWorksContent !!}
        </div>
</>
@endsection
~            