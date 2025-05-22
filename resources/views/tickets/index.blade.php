@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Lista de Tickets</h3>
                <div class="ml-auto">
                    <a href="{{ route('tickets.create') }}" class="btn btn-light text-primary font-weight-bold">
                        <i class="fas fa-plus"></i> Nuevo Ticket
                    </a>
                    <a href="{{ route('tickets.printAll') }}" class="btn btn-light text-primary font-weight-bold"
                        target="_blank">
                        <i class="fas fa-print"></i> Imprimir Todos
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered datatable">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="25%">Título</th>
                                <th width="20%">Estado</th>
                                <th width="20%">Tipo</th>
                                <th width="20%">Persona</th>
                                <th width="10%" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $ticket->titulo }}</td>
                                    <td class="align-middle text-center">
                                        <span
                                            class="badge 
                                    {{ optional($ticket->estadoTicket)->nombre_estado == 'Pendiente'
                                        ? 'badge-warning'
                                        : (optional($ticket->estadoTicket)->nombre_estado == 'En progreso'
                                            ? 'badge-info'
                                            : (optional($ticket->estadoTicket)->nombre_estado == 'Resuelto'
                                                ? 'badge-success'
                                                : 'badge-secondary')) }}">
                                            {{ optional($ticket->estadoTicket)->nombre_estado ?? 'No definido' }}
                                        </span>
                                    </td>
                                    <td class="align-middle">{{ optional($ticket->tipoTicket)->nombre ?? 'No definido' }}
                                    </td>
                                    <td class="align-middle">{{ optional($ticket->persona)->nombre ?? 'No definido' }}</td>
                                    <td class="align-middle text-center">
                                        <div class="d-inline-flex">
                                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-info mx-1"
                                                title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('tickets.edit', $ticket) }}"
                                                class="btn btn-sm btn-warning mx-1" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a href="{{ route('tickets.pdf', $ticket) }}"
                                                class="btn btn-sm btn-success mx-1" target="_blank" title="Imprimir">
                                                <i class="fas fa-print"></i>
                                            </a>

                                            <button type="button" class="btn btn-sm btn-danger btn-delete mx-1"
                                                title="Eliminar" onclick="confirmDelete({{ $ticket->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <form id="delete-form-{{ $ticket->id }}"
                                                action="{{ route('tickets.destroy', $ticket) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay tickets disponibles.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

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
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(ticketId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${ticketId}`).submit();
                }
            });
        }

        // Mostrar mensaje de éxito con SweetAlert2
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar'
            });
        @endif

        $(document).ready(function() {
            // Verificar si la tabla ya está inicializada
            if (!$.fn.DataTable.isDataTable('.datatable')) {
                $('.datatable').DataTable({
                    responsive: true,
                    autoWidth: false,
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                    },
                    columnDefs: [{
                        targets: [2, 5],
                        className: "text-center"
                    }]
                });
            }
        });
    </script>
@endpush
