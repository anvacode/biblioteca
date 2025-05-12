{{-- filepath: c:\xampp\htdocs\biblioteca\resources\views\reservas\index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Listado de Reservas</h3>
            <div class="ml-auto">
                <a href="{{ route('reservas.create') }}" class="btn btn-light text-primary font-weight-bold">
                    <i class="fas fa-plus"></i> Nueva Reserva
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover table-bordered datatable">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">Persona</th>
                            <th width="25%">Material</th>
                            <th width="15%">Fecha de Reserva</th>
                            <th width="15%" class="text-center">Estado</th>
                            <th width="20%" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservas as $reserva)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $reserva->persona->nombre }}</td>
                            <td class="align-middle">{{ $reserva->material->nombre }}</td>
                            <td class="align-middle">{{ $reserva->fecha_reserva->format('d/m/Y') }}</td>
                            <td class="align-middle text-center">
                                <span class="badge {{ $reserva->estado == 'pendiente' ? 'badge-warning' : ($reserva->estado == 'confirmada' ? 'badge-success' : 'badge-secondary') }}">
                                    {{ ucfirst($reserva->estado) }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-inline-flex">
                                    <a href="{{ route('reservas.show', $reserva) }}" 
                                       class="btn btn-sm btn-info mx-1"
                                       title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('reservas.edit', $reserva) }}" 
                                       class="btn btn-sm btn-warning mx-1"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('reservas.destroy', $reserva) }}" 
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger btn-delete mx-1"
                                                title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay reservas registradas.</td>
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
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
    .badge-success {
        background-color: #28a745;
    }
    .badge-secondary {
        background-color: #6c757d;
    }
    .btn-delete {
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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('.datatable').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        columnDefs: [
            { targets: [4, 5], className: "text-center" }
        ]
    });

    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush