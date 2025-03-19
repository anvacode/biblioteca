@extends('layouts.app') <!-- Extiende la plantilla principal llamada 'layouts.app' -->

@section('content') <!-- Define la sección 'content' que se insertará en la plantilla -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <!-- Encabezado de la tarjeta -->
                <div class="card-header">{{ __('Reset Password') }}</div>

                <!-- Cuerpo de la tarjeta -->
                <div class="card-body">
                    <!-- Si hay un mensaje de estado en la sesión, se muestra aquí -->
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }} <!-- Muestra el mensaje de éxito -->
                        </div>
                    @endif

                    <!-- Formulario para solicitar el restablecimiento de contraseña -->
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf <!-- Token CSRF para protección contra ataques CSRF -->

                        <!-- Campo para el correo electrónico -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <!-- Input de tipo email -->
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                <!-- Mensaje de error si el correo electrónico es inválido -->
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Botón para enviar el enlace de restablecimiento de contraseña -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection <!-- Fin de la sección 'content' -->