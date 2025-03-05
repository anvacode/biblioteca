<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca Digital - Login</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/library_folder.png') }}">
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        body {
            background-image: url("{{ asset('images/library_2.avif') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .login-box {
            background-color: rgba(255, 255, 255, 0.9); /* Fondo semitransparente */
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="font-sans antialiased flex items-center justify-center min-h-screen">
    <div class="login-box w-full max-w-md p-8">
        <div class="login-logo text-center mb-2">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/library_folder.png') }}" alt="Logo Biblioteca Digital" class="w-20 mx-auto">
            </a>
        </div>

        <div class="card">
            <div class="card-body login-card-body p-6">
                <p class="text-center text-lg font-semibold mb-6 text-gray-800">Inicia sesión para comenzar</p>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                        <div class="relative">
                            <input type="email" name="email" id="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300" placeholder="Correo electrónico" required autocomplete="email" autofocus>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300" placeholder="Contraseña" required>
                        </div>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Iniciar sesión
                        </button>
                    </div>
                </form>

                <div class="text-center mt-6 space-y-3">
                    <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">¿Olvidaste tu contraseña?</a>
                    <p class="text-gray-600">¿No tienes una cuenta? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Regístrate</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>