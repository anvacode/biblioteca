@extends('layouts.applogin')

@section('content')
<link rel="stylesheet" href="{{ asset('public/custom.css') }}">

<div class="register-box">
    <div class="login-logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('image.png') }}" alt="Logo" width="150">
        </a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Crea una cuenta para empezar</p>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                        placeholder="Nombre completo" name="name" value="{{ old('name') }}" required autofocus>

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

                <div class="input-group mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Correo electrónico" name="email" value="{{ old('email') }}" required>

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

                <div class="input-group mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Contraseña" name="password" required>

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

                <div class="input-group mb-3">
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="Confirmar contraseña" name="password_confirmation" required>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>

                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row justify-content-center my-4">
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                    </div>
                </div>
            </form>

            <div class="justify-content-center">
                <div class="mb-1">
                    <a href="{{ route('login') }}">¿Ya tienes una cuenta? Inicia sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
