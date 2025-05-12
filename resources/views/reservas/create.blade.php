@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3>Nueva Reserva</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('reservas.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="fecha_reserva">Fecha de Reserva</label>
                    <input type="datetime-local" name="fecha_reserva" id="fecha_reserva" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control" required>
                        <option value="pendiente">Pendiente</option>
                        <option value="confirmada">Confirmada</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="personas_id">Persona</label>
                    <select name="personas_id" id="personas_id" class="form-control" required>
                        @foreach($personas as $persona)
                            <option value="{{ $persona->id }}">{{ $persona->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="materiales_id">Material</label>
                    <select name="materiales_id" id="materiales_id" class="form-control" required>
                        @foreach($materiales as $material)
                            <option value="{{ $material->id }}">{{ $material->titulo }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Reserva
                </button>
                <a href="{{ route('reservas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </form>
        </div>
    </div>
</div>
@endsection