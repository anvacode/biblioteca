{{-- filepath: c:\xampp\htdocs\biblioteca\resources\views\tickets\show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Detalles del Ticket</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Título:</div>
                <div class="col-md-9">{{ $ticket->titulo }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Estado:</div>
                <div class="col-md-9">
                    <span class="badge 
                        {{ optional($ticket->estadoTicket)->nombre_estado == 'Pendiente' ? 'badge-warning' : 
                           (optional($ticket->estadoTicket)->nombre_estado == 'En progreso' ? 'badge-info' : 
                           (optional($ticket->estadoTicket)->nombre_estado == 'Resuelto' ? 'badge-success' : 'badge-secondary')) }}">
                        {{ optional($ticket->estadoTicket)->nombre_estado ?? 'No definido' }}
                    </span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Tipo:</div>
                <div class="col-md-9">{{ optional($ticket->tipoTicket)->nombre ?? 'No definido' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Persona:</div>
                <div class="col-md-9">{{ optional($ticket->persona)->nombre ?? 'No definido' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Descripción:</div>
                <div class="col-md-9">{{ $ticket->descripcion }}</div>
            </div>
            <div class="text-right">
                <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection