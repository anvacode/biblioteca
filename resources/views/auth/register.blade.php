@extends('layouts.applogin')

@section('title', 'Saber Athena - Register')

@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- FontAwesome -->
</head>

<style>
    body {
        background-image: url("{{ asset('images/library_3.avif') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    .register-box {
        background-color: rgba(255, 255, 255, 0.9); 
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px; /* Igual que en Login */
        padding: 2rem; 
        border-radius: 12px; 
        margin: auto; 
    }
    .register-box input {
        background-color: transparent; 
        border: 1px solid #ddd; 
        border-radius: 8px;
        padding: 0.75rem;
        width: 100%;
        margin-bottom: 0.75rem; 
    }
    .register-box input:focus {
        border-color: #3b82f6; 
        outline: none;
    }
    .register-box button {
        background-color: #3b82f6; 
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem;
        width: 100%;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .register-box button:hover {
        background-color: #2563eb; 
    }
    .logo {
        width: 40px; 
        height: auto; 
        margin-right: 12px; 
    }
    .register-logo a {
        color: #3b82f6; 
        font-size: 1.5rem; 
        font-weight: bold; 
    }
    .register-card-body {
        padding: 2rem; 
    }
    .register-box-msg {
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
    <div class="register-box">
        <!-- Logo y título -->
        <div class="register-logo">
            <a href="{{ url('/') }}">
                <span>Registrarse <i class="fas fa-user-plus ml-2"></i></span> <!-- Icono de FontAwesome -->
            </a>
        </div>

        <!-- Formulario -->
        <div class="register-card-body">
            <p class="register-box-msg">Crea una cuenta para empezar.</p>

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Campo de nombre completo -->
                <div class="input-group mb-3">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre completo">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Campo de correo electrónico -->
                <div class="input-group mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo electrónico">

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

                <!-- Campo de confirmar contraseña -->
                <div class="input-group mb-3">
                    <input id="password-confirm" type="password" class="form-control"
                        name="password_confirmation" required placeholder="Confirmar contraseña">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <!-- Botón de registrarse -->
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            Registrarse
                        </button>
                    </div>
                </div>
            </form>

            <!-- Enlace para iniciar sesión -->
            <p class="mt-3 mb-1">
                ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
            </p>
        </div>
    </div>
</div>

<!-- SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        event.preventDefault();

        Swal.fire({
            title: "Registrando cuenta",
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