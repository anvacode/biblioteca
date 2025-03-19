@extends('layouts.app') <!-- Extiende la plantilla principal llamada 'layouts.app' -->

@section('content') <!-- Define la sección 'content' que se insertará en la plantilla -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <!-- Encabezado de la tarjeta -->
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <!-- Cuerpo de la tarjeta -->
                <div class="card-body">
                    <!-- Mensaje para confirmar la contraseña -->
                    {{ __('Please confirm your password before continuing.') }}

                    <!-- Formulario para confirmar la contraseña -->
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf <!-- Token CSRF para protección contra ataques CSRF -->

                        <!-- Campo para la contraseña -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <!-- Input de tipo password -->
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                <!-- Mensaje de error si la contraseña es incorrecta -->
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <!-- Botón para confirmar la contraseña -->
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                <!-- Enlace para recuperar la contraseña -->
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection <!-- Fin de la sección 'content' -->