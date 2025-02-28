@extends('layouts.applogin')

@section('content')
<link rel="stylesheet" href="{{ asset('public/custom.css') }}">

<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('image.png') }}" alt="Logo" width="150">
        </a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Inicia sesión para comenzar tu sesión</p>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                        placeholder="Correo electrónico" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                        placeholder="Contraseña" name="password" required autocomplete="current-password">

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

                <div class="row justify-content-center my-4">
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                    </div>
                </div>
            </form>

            <div class="justify-content-center">
                <div class="mb-1">
                    <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
