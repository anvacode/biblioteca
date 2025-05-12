@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3>Detalles de la Reserva</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $reserva->id }}</td>
                </tr>
                <tr>
                    <th>Persona</th>
                    <td>{{ $reserva->persona->nombre }}</td>
                </tr>
                <tr>
                    <th>Material</th>
                    <td>{{ $reserva->material->titulo }}</td>
                </tr>
                <tr>
                    <th>Fecha de Reserva</th>
                    <td>{{ $reserva->fecha_reserva->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Estado</th>
                    <td>
                        <span class="badge {{ $reserva->estado == 'pendiente' ? 'badge-warning' : ($reserva->estado == 'confirmada' ? 'badge-success' : 'badge-secondary') }}">
                            {{ ucfirst($reserva->estado) }}
                        </span>
                    </td>
                </tr>
            </table>
            <a href="{{ route('reservas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
        </div>
    </div>
</div>
@endsection