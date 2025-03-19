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
                    <!-- Formulario para restablecer la contraseña -->
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf <!-- Token CSRF para protección contra ataques CSRF -->

                        <!-- Campo oculto para el token de restablecimiento de contraseña -->
                        <input type="hidden" name="token" value="{{ $token }}">

                        <!-- Campo para el correo electrónico -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <!-- Input de tipo email -->
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                <!-- Mensaje de error si el correo electrónico es inválido -->
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo para la nueva contraseña -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <!-- Input de tipo password -->
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                <!-- Mensaje de error si la contraseña no cumple con los requisitos -->
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Campo para confirmar la nueva contraseña -->
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <!-- Input de tipo password para confirmar la nueva contraseña -->
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <!-- Botón para enviar el formulario y restablecer la contraseña -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
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