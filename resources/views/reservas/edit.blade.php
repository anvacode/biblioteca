@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Reserva</h1>
    <form action="{{ route('reservas.update', $reserva) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="fecha_reserva">Fecha de Reserva</label>
            <input type="datetime-local" name="fecha_reserva" id="fecha_reserva" class="form-control" value="{{ $reserva->fecha_reserva->format('Y-m-d\TH:i') }}">
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <select name="estado" id="estado" class="form-control">
                <option value="pendiente" {{ $reserva->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="confirmada" {{ $reserva->estado == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                <option value="cancelada" {{ $reserva->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>
        <div class="form-group">
            <label for="personas_id">Persona</label>
            <select name="personas_id" id="personas_id" class="form-control">
                @foreach($personas as $persona)
                    <option value="{{ $persona->id }}" {{ $reserva->personas_id == $persona->id ? 'selected' : '' }}>
                        {{ $persona->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="materiales_id">Material</label>
            <select name="materiales_id" id="materiales_id" class="form-control">
                @foreach($materiales as $material)
                    <option value="{{ $material->id }}" {{ $reserva->materiales_id == $material->id ? 'selected' : '' }}>
                        {{ $material->titulo }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
@endsection