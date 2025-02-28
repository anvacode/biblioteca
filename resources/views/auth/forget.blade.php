@extends('layouts.applogin')

@section('content')
<div class="login-box">
  <div class="login-logo">
    <a href="{{ url('/') }}"><b>Recuperar</b> Contraseña</a>
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Ingresa tu correo y te enviaremos un enlace para restablecer tu contraseña.</p>

      @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}" id="resetForm">
        @csrf

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

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">
              Enviar enlace
            </button>
          </div>
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="{{ route('login') }}">Volver al login</a>
      </p>
    </div>
  </div>
</div>

<!-- SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('resetForm').addEventListener('submit', function(event) {
    event.preventDefault();

    Swal.fire({
      title: "Correo enviado",
      text: "Si el correo está registrado, recibirás un enlace para restablecer tu contraseña.",
      icon: "success",
      confirmButtonText: "Aceptar"
    }).then(() => {
      this.submit();
    });
  });
</script>

@endsection
