@extends('layouts.applogin')

@section('title', 'Biblioteca Digital - Register') 

@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<style>
    body {
        background-image: url("{{ asset('images/library-background.webp') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    .register-box {
        background-color: rgba(255, 255, 255, 0.9); /* Fondo semitransparente */
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px; /* Ancho más grande */
        padding: 2rem; /* Padding ajustado */
    }
    .register-box input {
        background-color: transparent; /* Fondo transparente para los inputs */
        border: 1px solid #ddd; /* Borde sutil */
        border-radius: 8px;
        padding: 0.75rem;
        width: 100%;
        margin-bottom: 0.75rem; /* Menor margen inferior */
    }
    .register-box input:focus {
        border-color: #3b82f6; /* Borde azul al enfocar */
        outline: none;
    }
    .register-box button {
        background-color: #3b82f6; /* Color azul para el botón */
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem;
        width: 100%;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .register-box button:hover {
        background-color: #2563eb; /* Color azul más oscuro al pasar el mouse */
    }
</style>

<div class="flex items-center justify-center min-h-screen">
    <div class="register-box">
        <p class="text-center text-xl font-semibold mb-6 text-gray-800">Crea una cuenta para empezar</p>
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Nombre Completo -->
            <div class="mb-3"> <!-- Reducido de mb-4 a mb-3 -->
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 @error('name') border-red-500 @enderror" placeholder="Nombre completo" value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Correo Electrónico -->
            <div class="mb-3"> <!-- Reducido de mb-4 a mb-3 -->
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 @error('email') border-red-500 @enderror" placeholder="Correo electrónico" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="mb-3"> <!-- Reducido de mb-4 a mb-3 -->
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 @error('password') border-red-500 @enderror" placeholder="Contraseña" required>
                @error('password')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mb-3"> <!-- Reducido de mb-4 a mb-3 -->
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300 @error('password_confirmation') border-red-500 @enderror" placeholder="Confirmar contraseña" required>
                @error('password_confirmation')
                    <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Botón Registrar -->
            <div class="flex justify-center mt-4"> <!-- Reducido de mt-6 a mt-4 -->
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Registrar
                </button>
            </div>
        </form>

        <div class="text-center mt-4"> <!-- Reducido de mt-6 a mt-4 -->
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">¿Ya tienes una cuenta? Inicia sesión</a>
        </div>
    </div>
</div>

@endsection