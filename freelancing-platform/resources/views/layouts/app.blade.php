<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Freelancing Platform')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3977be33c4.js" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>


</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-md p-4">
            @include('components.header')
        </header>

        <!-- Main Content -->
        <main class="flex-grow p-4">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-green-800 text-white p-6 mt-12 shadow-inner">
    <div class="container mx-auto flex flex-col items-center justify-between space-y-4 sm:flex-row sm:space-y-0">
        <div class="text-center sm:text-left">
            <p class="text-lg font-semibold">&copy; {{ date('Y') }} No. 1 Escrow platform.</p>
        </div>
        <div class="text-center sm:text-right">
            <a href={{route("terms")}} class="text-white hover:text-gray-200 transition-colors">Terms of Service</a>
        </div>
    </div>
</footer>

    </div>
</body>
</html>
