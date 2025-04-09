@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Encabezado -->
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1><i class="fas fa-history"></i> Historial de Tickets</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Historial</li>
            </ol>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Filtros</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('historial-tickets.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Ticket ID:</label>
                            <input type="number" name="ticket_id" class="form-control" 
                                   value="{{ request('ticket_id') }}" placeholder="Filtrar por ticket...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Fecha inicio:</label>
                            <input type="date" name="fecha_inicio" class="form-control" 
                                   value="{{ request('fecha_inicio') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Fecha fin:</label>
                            <input type="date" name="fecha_fin" class="form-control" 
                                   value="{{ request('fecha_fin') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                        <a href="{{ route('historial-tickets.index') }}" class="btn btn-default">
                            <i class="fas fa-sync-alt"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Listado -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registros de Historial</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 15%">Ticket</th>
                            <th style="width: 15%">Fecha</th>
                            <th style="width: 15%">Responsable</th>
                            <th style="width: 40%">Comentario</th>
                            <th style="width: 10%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historial as $registro)
                        <tr>
                            <td>{{ $registro->id }}</td>
                            <td>
                                <a href="{{ route('tickets.show', $registro->ticket->id) }}">
                                    #{{ $registro->ticket->id }}
                                </a>
                            </td>
                            <td>{{ $registro->fecha_cambio->format('d/m/Y H:i') }}</td>
                            <td>{{ $registro->persona_responsable }}</td>
                            <td>{{ Str::limit($registro->comentario, 50) }}</td>
                            <td>
                                <a href="{{ route('historial-tickets.export', $registro->ticket) }}" 
                                   class="btn btn-sm btn-danger" title="Exportar PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No hay registros de historial</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer clearfix">
            {{ $historial->links() }}
        </div>
    </div>
</div>
@endsection