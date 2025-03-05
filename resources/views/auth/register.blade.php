@extends('layouts.applogin')

@section('content')

<link rel="stylesheet" href="{{ asset('public/custom.css') }}">

<div class="register-box w-full max-w-md p-8 bg-white shadow-lg rounded-lg">
    <div class="login-logo text-center mb-6">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/library_folder.png') }}" alt="Logo" class="w-24 mx-auto">
        </a>
    </div>

    <div class="card">
        <div class="card-body register-card-body p-6">
            <p class="text-center text-xl font-semibold mb-6 text-gray-800">Crea una cuenta para empezar</p>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <!-- Nombre Completo -->
                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre completo</label>
                    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300 @error('name') border-red-500 @enderror" 
                        placeholder="Nombre completo" name="name" value="{{ old('name') }}" required autofocus>
                    
                    @error('name')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Correo Electrónico -->
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                    <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300 @error('email') border-red-500 @enderror"
                        placeholder="Correo electrónico" name="email" value="{{ old('email') }}" required>

                    @error('email')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="mb-5">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                    <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300 @error('password') border-red-500 @enderror"
                        placeholder="Contraseña" name="password" required>

                    @error('password')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mb-5">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                    <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300 @error('password_confirmation') border-red-500 @enderror"
                        placeholder="Confirmar contraseña" name="password_confirmation" required>

                    @error('password_confirmation')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Botón Registrar -->
                <div class="flex justify-center mt-6">
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition duration-300">Registrar</button>
                </div>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">¿Ya tienes una cuenta? Inicia sesión</a>
            </div>
        </div>
    </div>
</div>

@endsection
