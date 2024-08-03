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
        <footer class="bg-white p-4 text-center shadow-md">
            &copy; {{ date('Y') }} Freelancing Platform
        </footer>
    </div>
</body>
</html>
