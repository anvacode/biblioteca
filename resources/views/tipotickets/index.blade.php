@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-secondary">
                <h3 class="card-title">Tipos de Tickets</h3>
                <a href="{{ route('tipotickets.create') }}" class="btn btn-primary float-right">
                    <i class="fas fa-plus"></i> Nuevo
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tipotickets as $tipoticket)
                            <tr>
                                <td>{{ $tipoticket->id }}</td>
                                <td>{{ $tipoticket->nombre }}</td>
                                <td>{{ $tipoticket->descripcion }}</td>
                                <td>
                                    <button class="btn btn-status {{ $tipoticket->estado ? 'btn-success' : 'btn-danger' }}"
                                        data-id="{{ $tipoticket->id }}" data-estado="{{ $tipoticket->estado ? 1 : 0 }}">
                                        <i class="fas {{ $tipoticket->estado ? 'fa-check' : 'fa-times' }} mr-1"></i>
                                        {{ $tipoticket->estado ? 'Activo' : 'Inactivo' }}
                                    </button>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('tipotickets.edit', $tipoticket->id) }}"
                                        class="btn btn-info btn-action mx-1" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form class="d-inline delete-form"
                                        action="{{ route('tipotickets.destroy', $tipoticket->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-action mx-1 btn-delete"
                                            title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .btn-status {
                min-width: 100px;
                padding: 0.25rem 0.5rem;
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

            .btn-action {
                width: 32px;
                height: 32px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
            }

            .btn-info {
                color: white;
            }

            .btn-danger {
                color: white;
            }

            .mx-1 {
                margin-left: 0.25rem;
                margin-right: 0.25rem;
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
                    }
                });

                // Manejo del cambio de estado - Versión mejorada
                $(document).on('click', '.btn-status', function(e) {
                    e.preventDefault();
                    const button = $(this);
                    const id = button.data('id');
                    const currentEstado = parseInt(button.data('estado'));
                    const newEstado = currentEstado ? 0 : 1;

                    // Cambio visual inmediato (antes de la petición AJAX)
                    button.prop('disabled', true);
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
                            button.prop('disabled', false);
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        error: function(xhr) {
                            // Revertir cambios si hay error
                            button.prop('disabled', false);
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
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminarlo!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: form.attr('action'),
                                method: 'POST',
                                data: {
                                    _method: 'DELETE',
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    if (response.success) {
                                        form.closest('tr').fadeOut(300, function() {
                                            $(this).remove();
                                        });
                                        Swal.fire(
                                            '¡Eliminado!',
                                            response.message,
                                            'success'
                                        );
                                    }
                                },
                                error: function() {
                                    Swal.fire(
                                        'Error',
                                        'No se pudo eliminar el registro',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
