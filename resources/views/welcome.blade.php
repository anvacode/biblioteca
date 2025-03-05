<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca Digital</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/library_folder.png') }}">
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        .bg-library {
            background-image: url("{{ asset('images/library-background.webp') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="bg-library text-white flex flex-col flex-grow min-h-screen">
        <div class="flex-1 flex flex-col items-center justify-center">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl p-8 rounded-lg">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:justify-center lg:col-start-2 items-center space-x-4">
                        <img src="{{ asset('images/library_folder.png') }}" alt="Logo de la Biblioteca Digital" class="h-28 w-auto">
                        <h1 class="text-6xl font-bold">Biblioteca Digital</h1>
                    </div>
                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                    
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                    
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                        
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>
                <main class="mt-6 text-center">
                    <h2 class="text-3xl font-semibold">Bienvenido a la Biblioteca Digital</h2>
                    <p class="mt-4 text-lg">
                        Explora nuestra colección de libros, revistas y recursos digitales.
                    </p>
                    <div class="mt-8 space-x-4">
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                            Registrarse
                        </a>
                    </div>
                </main>
            </div>
        </div>
        <footer class="py-8 text-center text-lg">
            Biblioteca Digital &copy; {{ date('Y') }}. Todos los derechos reservados.
        </footer>
    </div>
</body>

</html>
