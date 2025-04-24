{{-- filepath: c:\xampp\htdocs\biblioteca\resources\views\estadostickets\edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <h3 class="mb-0">Editar Estado</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('estados-tickets.update', $estado->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre_estado">Nombre del Estado</label>
                    <input type="text" name="nombre_estado" id="nombre_estado" class="form-control @error('nombre_estado') is-invalid @enderror" value="{{ old('nombre_estado', $estado->nombre_estado) }}" required>
                    @error('nombre_estado')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="color" name="color" id="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color', $estado->color) }}" required>
                    @error('color')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="orden">Orden</label>
                    <input type="number" name="orden" id="orden" class="form-control @error('orden') is-invalid @enderror" value="{{ old('orden', $estado->orden) }}" min="0" required>
                    @error('orden')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="activo" id="activo" class="custom-control-input" value="1" {{ old('activo', $estado->activo) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="activo">Activo</label>
                    </div>
                </div>

                <div class="form-group text-right">
                    <a href="{{ route('estados-tickets.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-warning">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection