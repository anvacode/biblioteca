@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Estados de Tickets</h3>
                <div class="ml-auto">
                    <a href="{{ route('estados-tickets.create') }}" class="btn btn-light text-primary font-weight-bold">
                        <i class="fas fa-plus"></i> Nuevo Estado
                    </a>
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
                                            <a href="{{ route('estados-tickets.edit', $estado->id) }}"
                                                class="btn btn-sm btn-warning mx-1" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>

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
        // Verificar si la tabla ya está inicializada
        if (!$.fn.DataTable.isDataTable('.datatable')) {
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
        }

        $(document).on('click', '.btn-status:not(:disabled)', function(e) {
            e.preventDefault();
            const button = $(this);
            const estadoId = button.data('id');
            const url = `/estados-tickets/${estadoId}/status`;
            const newEstado = button.data('estado') ? 0 : 1;

            Swal.fire({
                title: '¿Estás seguro?',
                text: `¿Deseas cambiar el estado a ${newEstado ? 'Activo' : 'Inactivo'}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.addClass('animate__animated animate__pulse');
                    button.prop('disabled', true);

                    $.ajax({
                        url: url,
                        type: 'POST',
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
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Estado actualizado!',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                            button.prop('disabled', false);
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseJSON);
                            button.prop('disabled', false);
                            Swal.fire('Error', xhr.responseJSON?.message || 'Error al actualizar el estado', 'error');
                        },
                        complete: function() {
                            button.removeClass('animate__animated animate__pulse');
                        }
                    });
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
    });
</script>
@endpush
