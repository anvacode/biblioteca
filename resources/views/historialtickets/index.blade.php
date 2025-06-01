@extends('layouts.app')

@push('styles')
    <style>
        .btn-status {
            min-width: 100px;
            padding: 0.375rem 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-status:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-status i {
            font-size: 0.9rem;
        }

        .card-header .btn-light {
            background-color: white;
            border-color: white;
            color: #007bff !important;
            font-weight: 600;
            transition: all 0.3s;
        }

        .card-header .btn-light:hover {
            background-color: #f8f9fa;
            border-color: #f8f9fa;
        }

        .table td {
            vertical-align: middle !important;
        }

        .text-center {
            text-align: center !important;
        }

        .d-inline-flex {
            display: inline-flex;
        }

        .d-inline-block {
            display: inline-block;
        }

        .btn-warning,
        .btn-danger {
            color: white !important;
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .mx-1 {
            margin-left: 0.25rem !important;
            margin-right: 0.25rem !important;
        }

        .card-header .ml-auto {
            margin-left: auto !important;
        }

        /* Estilos adicionales para mejorar la presentación */
        .historial-header {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #343a40;
        }
        .form-label {
            font-weight: 500;
        }
        .table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .table-bordered {
            border-radius: 8px;
            overflow: hidden;
        }
        .table tbody tr:hover {
            background-color: #f1f3f5;
        }
        .filter-form {
            background: #f8f9fa;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
    </style>
@endpush

@section('content')
<div class="container">
    <h1 class="historial-header">Historial de Tickets</h1>

    <!-- Filtros -->
    <form method="GET" action="{{ route('historial-tickets.index') }}" class="mb-4 row g-3 filter-form">
        <div class="col-md-4">
            <label for="ticket_id" class="form-label">Ticket</label>
            <select name="ticket_id" id="ticket_id" class="form-select">
                <option value="">Todos</option>
                @foreach($tickets as $ticket)
                    <option value="{{ $ticket->id }}" {{ request('ticket_id') == $ticket->id ? 'selected' : '' }}>
                        {{ $ticket->titulo ?? $ticket->id }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="fecha_inicio" class="form-label">Fecha inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
        </div>
        <div class="col-md-3">
            <label for="fecha_fin" class="form-label">Fecha fin</label>
            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100 btn-status">Filtrar</button>
        </div>
    </form>

    <!-- Tabla de historial -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ticket</th>
                <th>Usuario</th>
                <th>Fecha de Cambio</th>
                <th>Comentario</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($historial as $registro)
                <tr>
                    <td>{{ $registro->id }}</td>
                    <td>
                        {{ $registro->ticket->titulo ?? $registro->tipo_ticket_id ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $registro->usuario->name ?? $registro->user_id ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $registro->created_at ? $registro->created_at->format('Y-m-d H:i') : 'N/A' }}
                    </td>
                    <td>{{ $registro->comentario }}</td>
                    <td>{{ $registro->accion ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay registros para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    <div>
        {{ $historial->withQueryString()->links() }}
    </div>
</div>
@endsection