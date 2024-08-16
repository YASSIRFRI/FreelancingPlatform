<!-- resources/views/layouts/guest.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Eza')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
    <body class="bg-gray-100">
    <header class="bg-white shadow-md p-2">
            @include('components.header')
        </header>
    <div class="min-h-screen flex flex-col justify-center">
        <main class="">
            @yield('content')
        </main>

    </div>
</body>
</html>
