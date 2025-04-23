@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Estados de Tickets</h3>
                <div class="ml-auto">
                    <button class="btn btn-light text-primary font-weight-bold" data-toggle="modal"
                        data-target="#createEstadoModal">
                        <i class="fas fa-plus"></i> Nuevo Estado
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered datatable">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%" class="text-center">Orden</th>
                                <th width="30%">Nombre</th>
                                <th width="15%" class="text-center">Estado</th>
                                <th width="10%" class="text-center">Tickets</th>
                                <th width="15%" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($estados as $estado)
                                @php
                                    [$r, $g, $b] = sscanf($estado->color, '#%02x%02x%02x');
                                    $color_tenue = "rgba($r, $g, $b, 0.15)";
                                @endphp
                                <tr data-update-url="{{ route('estados-tickets.updateStatus', $estado->id) }}">
                                    <td class="align-middle text-center">{{ $estado->orden }}</td>
                                    <td class="align-middle nombre-estado"
                                        style="background-color: {{ $color_tenue }}; color: #212529; border-left: 4px solid {{ $estado->color }};">
                                        {{ $estado->nombre_estado }}
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-inline-block">
                                            <button
                                                class="btn btn-status {{ $estado->activo ? 'btn-success' : 'btn-danger' }}"
                                                data-id="{{ $estado->id }}" data-estado="{{ $estado->activo ? 1 : 0 }}"
                                                @if ($estado->isProtected()) disabled @endif>
                                                <i class="fas {{ $estado->activo ? 'fa-check' : 'fa-times' }} mr-1"></i>
                                                {{ $estado->activo ? 'Activo' : 'Inactivo' }}
                                            </button>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">{{ $estado->tickets_count }}</td>
                                    <td class="align-middle text-center">
                                        <div class="d-inline-flex">
                                            <button class="btn btn-sm btn-warning mx-1 edit-btn"
                                                data-id="{{ $estado->id }}" data-nombre="{{ $estado->nombre_estado }}"
                                                data-color="{{ $estado->color }}" data-orden="{{ $estado->orden }}"
                                                data-activo="{{ $estado->activo }}" title="Editar"
                                                @if ($estado->isProtected()) disabled @endif>
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            @if (!$estado->isProtected() && $estado->tickets_count == 0)
                                                <button type="button" class="btn btn-sm btn-danger mx-1 delete-btn"
                                                    data-id="{{ $estado->id }}" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
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

    <!-- Modal Crear Estado -->
    <div class="modal fade" id="createEstadoModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crear Nuevo Estado</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('estados-tickets.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre_estado">Nombre del Estado</label>
                            <input type="text" class="form-control" id="nombre_estado" name="nombre_estado" required>
                        </div>
                        <div class="form-group">
                            <label for="color">Color</label>
                            <input type="color" class="form-control" id="color" name="color" value="#6c757d"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="orden">Orden</label>
                            <input type="number" class="form-control" id="orden" name="orden" min="0"
                                value="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Estado -->
    <div class="modal fade" id="editEstadoModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Editar Estado</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_nombre_estado">Nombre del Estado</label>
                            <input type="text" class="form-control" id="edit_nombre_estado" name="nombre_estado"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="edit_color">Color</label>
                            <input type="color" class="form-control" id="edit_color" name="color" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_orden">Orden</label>
                            <input type="number" class="form-control" id="edit_orden" name="orden" min="0"
                                required>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="edit_activo" name="activo"
                                    value="1">
                                <label class="custom-control-label" for="edit_activo">Activo</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .btn-status {
            min-width: 100px;
            padding: 0.5rem 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            border: none;
            border-radius: 0.25rem;
        }

        .btn-status:not(:disabled):hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-status:disabled {
            opacity: 0.65;
        }

        .btn-status i {
            font-size: 0.85rem;
            margin-right: 0.35rem;
        }

        .nombre-estado {
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.2s;
            border-radius: 0.25rem;
        }

        .table-hover tbody tr:hover td {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .btn-warning {
            background-color: #ffc107 !important;
            border-color: #ffc107 !important;
        }

        .btn-danger {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
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
                columnDefs: [{
                    targets: [0, 2, 3, 4],
                    className: "text-center",
                    orderable: true,
                    searchable: false
                }],
                order: [
                    [0, 'asc']
                ]
            });

            $(document).on('click', '.btn-status:not(:disabled)', function(e) {
                e.preventDefault();
                const button = $(this);
                const estadoId = button.data('id');
                const url = `/estados-tickets/${estadoId}/status`;
                const newEstado = button.data('estado') ? 0 : 1;

                button.addClass('animate__animated animate__pulse');
                button.prop('disabled', true);

                $.ajax({
                    url: url,
                    type: 'POST', // Usamos POST pero con _method PATCH
                    data: {
                        _method: 'PATCH',
                        estado: newEstado,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            button.data('estado', newEstado ? 1 : 0)
                                .removeClass('btn-success btn-danger')
                                .addClass(newEstado ? 'btn-success' : 'btn-danger')
                                .html(
                                    `<i class="fas ${newEstado ? 'fa-check' : 'fa-times'} mr-1"></i> ${newEstado ? 'Activo' : 'Inactivo'}`
                                    );
                        }
                        button.prop('disabled', false);
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseJSON);
                        button.prop('disabled', false);
                        Swal.fire('Error', xhr.responseJSON?.message || 'Error al actualizar',
                            'error');
                    },
                    complete: function() {
                        button.removeClass('animate__animated animate__pulse');
                    }
                });
            });
            e.preventDefault();
            const button = $(this);
            const estadoId = button.data('id');
            const url = "{{ route('estados-tickets.updateStatus', ':id') }}".replace(':id', estadoId);
            const newEstado = button.data('estado') ? 0 : 1;

            console.log('Enviando solicitud:', {
                url,
                newEstado
            }); // Debug en consola

            button.addClass('animate__animated animate__pulse');
            button.prop('disabled', true);

            $.ajax({
                url: url,
                method: 'PATCH',
                data: {
                    estado: newEstado,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log('Respuesta recibida:', response); // Debug en consola
                    if (response.success) {
                        button.removeClass('btn-success btn-danger')
                            .addClass(response.nuevo_estado ? 'btn-success' : 'btn-danger')
                            .data('estado', response.nuevo_estado ? 1 : 0)
                            .html(
                                `<i class="fas ${response.nuevo_estado ? 'fa-check' : 'fa-times'} mr-1"></i> ${response.nuevo_estado ? 'Activo' : 'Inactivo'}`
                            );

                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Error en la solicitud:', xhr
                        .responseJSON); // Debug en consola
                    Swal.fire(
                        'Error',
                        xhr.responseJSON?.message || 'Error al actualizar el estado',
                        'error'
                    );
                },
                complete: function() {
                    button.removeClass('animate__animated animate__pulse');
                    button.prop('disabled', false);
                }
            });
        });

        $(document).on('click', '.delete-btn', function() {
            const button = $(this);
            const estadoId = button.data('id');
            const url = "{{ route('estados-tickets.destroy', ':id') }}".replace(':id', estadoId);

            Swal.fire({
                title: '¿Confirmar eliminación?',
                text: "¡Esta acción no se puede deshacer!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: "{{ csrf_token() }}"
                        },
                        beforeSend: () => {
                            button.prop('disabled', true);
                            Swal.showLoading();
                        },
                        success: (response) => {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: response.success,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: (xhr) => {
                            const errorMsg = xhr.responseJSON?.error ||
                                'Error al eliminar el estado';
                            Swal.fire('Error', errorMsg, 'error');
                            button.prop('disabled', false);
                        }
                    });
                }
            });
        });

        $('.edit-btn:not(:disabled)').click(function() {
        const button = $(this);
        const estadoId = button.data('id');

        $('#edit_nombre_estado').val(button.data('nombre')).prop('readonly', button.data(
            'protected') === 'true');
        $('#edit_color').val(button.data('color'));
        $('#edit_orden').val(button.data('orden'));
        $('#edit_activo').prop('checked', button.data('activo'));

        $('#editForm').attr('action', `/estados-tickets/${estadoId}`);
        $('#editEstadoModal').modal('show');
        });
        });
    </script>
@endpush
