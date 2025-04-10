@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Tipos de Tickets</h3>
            <div class="ml-auto">
                <a href="{{ route('tipotickets.create') }}" class="btn btn-light text-primary font-weight-bold">
                    <i class="fas fa-plus"></i> Nuevo Tipo
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered datatable">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="25%">Nombre</th>
                            <th width="40%">Descripción</th>
                            <th width="15%" class="text-center">Estado</th>
                            <th width="15%" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tipotickets as $tipoticket)
                        <tr>
                            <td class="align-middle">{{ $tipoticket->id }}</td>
                            <td class="align-middle">{{ $tipoticket->nombre }}</td>
                            <td class="align-middle">{{ $tipoticket->descripcion }}</td>
                            <td class="align-middle text-center">
                                <div class="d-inline-block">
                                    <button class="btn btn-status {{ $tipoticket->estado ? 'btn-success' : 'btn-danger' }}"
                                        data-id="{{ $tipoticket->id }}"
                                        data-estado="{{ $tipoticket->estado ? 1 : 0 }}">
                                        <i class="fas {{ $tipoticket->estado ? 'fa-check' : 'fa-times' }} mr-1"></i>
                                        {{ $tipoticket->estado ? 'Activo' : 'Inactivo' }}
                                    </button>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-inline-flex">
                                    <a href="{{ route('tipotickets.edit', $tipoticket->id) }}" 
                                       class="btn btn-sm btn-warning mx-1"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('tipotickets.destroy', $tipoticket->id) }}" 
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
                        @endforeach
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

    /* Estilo para el botón Nuevo */
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
    
    /* Estilo para las celdas de la tabla */
    .table td {
        vertical-align: middle !important;
    }
    
    /* Centrado de contenido */
    .text-center {
        text-align: center !important;
    }
    
    /* Contenedores flex para centrado */
    .d-inline-flex {
        display: inline-flex;
    }
    
    .d-inline-block {
        display: inline-block;
    }
    
    /* Estilo para los botones de acción */
    .btn-warning, .btn-danger {
        color: white !important;
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    /* Espaciado entre botones */
    .mx-1 {
        margin-left: 0.25rem !important;
        margin-right: 0.25rem !important;
    }
    
    /* Alineación del botón en el header */
    .card-header .ml-auto {
        margin-left: auto !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Inicialización de DataTables
    $('.datatable').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        columnDefs: [
            { targets: [3, 4], className: "text-center" }
        ]
    });

    // Manejo del cambio de estado
    $(document).on('click', '.btn-status', function(e) {
        e.preventDefault();
        const button = $(this);
        const id = button.data('id');
        const currentEstado = parseInt(button.data('estado'));
        const newEstado = currentEstado ? 0 : 1;

        // Animación de cambio
        button.addClass('animate__animated animate__pulse');

        // Actualización visual inmediata
        button.removeClass('btn-success btn-danger')
            .addClass(newEstado ? 'btn-success' : 'btn-danger')
            .data('estado', newEstado)
            .html(
                `<i class="fas ${newEstado ? 'fa-check' : 'fa-times'} mr-1"></i> ${newEstado ? 'Activo' : 'Inactivo'}`
            );

        // Petición AJAX
        $.ajax({
            url: `/tipotickets/${id}/status`,
            method: 'PATCH',
            data: {
                estado: newEstado,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                button.removeClass('animate__animated animate__pulse');
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            },
            error: function() {
                // Revertir cambios si hay error
                button.removeClass('animate__animated animate__pulse');
                button.removeClass('btn-success btn-danger')
                    .addClass(currentEstado ? 'btn-success' : 'btn-danger')
                    .data('estado', currentEstado)
                    .html(
                        `<i class="fas ${currentEstado ? 'fa-check' : 'fa-times'} mr-1"></i> ${currentEstado ? 'Activo' : 'Inactivo'}`
                    );
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo actualizar el estado',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    // Manejo del botón eliminar
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