@extends('layouts.applogin')

@section('title', 'Saber Athena - Iniciar sesión')

@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- FontAwesome -->
</head>

<style>
    body {
        background-image: url("{{ asset('images/login-back.jpg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    .login-box {
        background-color: rgba(255, 255, 255, 0.9); 
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px; 
        padding: 2rem; 
        border-radius: 12px; 
        margin: auto; 
    }
    .login-box input {
        background-color: transparent; 
        border: 1px solid #ddd; 
        border-radius: 8px;
        padding: 0.75rem;
        width: 100%;
        margin-bottom: 0.75rem; 
    }
    .login-box input:focus {
        border-color: #3b82f6; 
        outline: none;
    }
    .login-box button {
        background-color: #3b82f6; 
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem;
        width: 100%;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .login-box button:hover {
        background-color: #2563eb; 
    }
    .logo {
        width: 40px; 
        height: auto; 
        margin-right: 12px; 
    }
    .login-logo a {
        color: #3b82f6; 
        font-size: 1.5rem; 
        font-weight: bold; 
    }
    .login-card-body {
        padding: 2rem; 
    }
    .login-box-msg {
        margin-bottom: 1.5rem; 
        font-size: 1rem; 
        color: #4b5563; 
    }
    .alert-success {
        background-color: #d1fae5; 
        color: #065f46; 
        padding: 0.75rem; 
        border-radius: 8px; 
        margin-bottom: 1rem; 
    }
    .invalid-feedback {
        color: #dc2626; 
        font-size: 0.875rem; 
        margin-top: 0.25rem; 
    }
</style>

<div class="flex items-center justify-center min-h-screen">
    <div class="login-box">
        <!-- Logo y título -->
        <div class="login-logo">
            <a href="{{ url('/') }}">
                <span>Iniciar Sesión <i class="fas fa-sign-in-alt ml-2"></i></span> <!-- Icono de FontAwesome -->
            </a>
        </div>

        <!-- Mensaje de estado -->
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <!-- Formulario -->
        <div class="login-card-body">
            <p class="login-box-msg">Ingresa tus credenciales para acceder.</p>

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Campo de correo electrónico -->
                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo electrónico">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Campo de contraseña -->
                <div class="input-group mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required placeholder="Contraseña">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Botón de iniciar sesión -->
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            Iniciar sesión
                        </button>
                    </div>
                </div>
            </form>

            <!-- Enlace para recuperar contraseña -->
            <p class="mt-3 mb-1">
                <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
            </p>

            <!-- Enlace para registrarse -->
            <p class="mt-3 mb-1">
                ¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a>
            </p>
        </div>
    </div>
</div>

<!-- SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();

        Swal.fire({
            title: "Iniciando sesión",
            text: "Por favor, espera un momento...",
            icon: "info",
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        this.submit();
    });
</script>

@endsection