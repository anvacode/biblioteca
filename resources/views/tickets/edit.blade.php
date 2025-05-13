{{-- filepath: c:\xampp\htdocs\biblioteca\resources\views\tickets\edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Editar Ticket</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('tickets.update', $ticket) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="titulo">Título</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo', $ticket->titulo) }}" required>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required>{{ old('descripcion', $ticket->descripcion) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="estado_ticket_id">Estado</label>
                    <select name="estado_ticket_id" id="estado_ticket_id" class="form-control" required>
                        @foreach($estados as $estado)
                            <option value="{{ $estado->id }}" {{ $estado->id == $ticket->estado_ticket_id ? 'selected' : '' }}>
                                {{ $estado->nombre_estado }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="tipo_ticket_id">Tipo</label>
                    <select name="tipo_ticket_id" id="tipo_ticket_id" class="form-control" required>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}" {{ $tipo->id == $ticket->tipo_ticket_id ? 'selected' : '' }}>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="personas_id">Persona</label>
                    <select name="personas_id" id="personas_id" class="form-control" required>
                        @foreach($personas as $persona)
                            <option value="{{ $persona->id }}" {{ $persona->id == $ticket->personas_id ? 'selected' : '' }}>
                                {{ $persona->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="text-right">
                    <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection