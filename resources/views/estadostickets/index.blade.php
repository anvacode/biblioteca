@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Estados de Tickets</h3>
            <div class="ml-auto">
                <button class="btn btn-light text-primary font-weight-bold" data-toggle="modal" data-target="#createEstadoModal">
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
                            <th width="25%">Nombre</th>
                            <th width="15%" class="text-center">Color</th>
                            <th width="10%" class="text-center">Estado</th>
                            <th width="10%" class="text-center">Tickets</th>
                            <th width="15%" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estados as $estado)
                        <tr>
                            <td class="align-middle text-center">{{ $estado->orden }}</td>
                            <td class="align-middle">{{ $estado->nombre_estado }}</td>
                            <td class="align-middle text-center">
                                <span class="badge p-2 d-inline-block" style="background-color: {{ $estado->color }}; color: white; min-width: 80px;">
                                    {{ $estado->color }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                @if($estado->activo)
                                    <span class="badge badge-success p-2">Activo</span>
                                @else
                                    <span class="badge badge-secondary p-2">Inactivo</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">{{ $estado->tickets_count }}</td>
                            <td class="align-middle text-center">
                                <div class="d-inline-flex">
                                    <button class="btn btn-sm btn-warning mx-1 edit-btn" 
                                            data-id="{{ $estado->id }}"
                                            data-nombre="{{ $estado->nombre_estado }}"
                                            data-color="{{ $estado->color }}"
                                            data-orden="{{ $estado->orden }}"
                                            data-activo="{{ $estado->activo }}"
                                            data-protected="{{ in_array($estado->nombre_estado, $protectedStates) ? 'true' : 'false' }}"
                                            title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    @if(!in_array($estado->nombre_estado, $protectedStates) && $estado->tickets_count == 0)
                                    <form action="{{ route('estados-tickets.destroy', $estado->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mx-1" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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

<!-- Create Modal -->
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
                        <input type="color" class="form-control" id="color" name="color" value="#6c757d" required>
                    </div>
                    <div class="form-group">
                        <label for="orden">Orden</label>
                        <input type="number" class="form-control" id="orden" name="orden" min="0" value="0" required>
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

<!-- Edit Modal -->
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
                        <input type="text" class="form-control" id="edit_nombre_estado" name="nombre_estado" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_color">Color</label>
                        <input type="color" class="form-control" id="edit_color" name="color" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_orden">Orden</label>
                        <input type="number" class="form-control" id="edit_orden" name="orden" min="0" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="edit_activo" name="activo" value="1">
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
    
    /* Estilo para los badges de color */
    .badge {
        min-width: 80px;
        padding: 0.5em 0.75em;
        font-size: 0.9em;
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
    
    /* Estilo para los botones de estado */
    .badge-success, .badge-secondary {
        padding: 0.5em 0.75em;
        font-size: 0.9em;
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
            { targets: [0, 2, 3, 4, 5], className: "text-center" }
        ]
    });

    // Manejar clic en botón de edición
    $('.edit-btn').click(function() {
        var estadoId = $(this).data('id');
        var isProtected = $(this).data('protected') === 'true';
        
        $('#edit_nombre_estado').val($(this).data('nombre'));
        $('#edit_color').val($(this).data('color'));
        $('#edit_orden').val($(this).data('orden'));
        $('#edit_activo').prop('checked', $(this).data('activo'));
        
        if (isProtected) {
            $('#edit_nombre_estado').prop('readonly', true);
        } else {
            $('#edit_nombre_estado').prop('readonly', false);
        }
        
        $('#editForm').attr('action', '/estados-tickets/' + estadoId);
        $('#editEstadoModal').modal('show');
    });
    
    // Confirmación para eliminar
    $(document).on('click', '.btn-danger', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        
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