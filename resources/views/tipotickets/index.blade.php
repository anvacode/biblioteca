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
                                    data-id="{{ $tipoticket->id }}"
                                    data-estado="{{ $tipoticket->estado ? 1 : 0 }}">
                                <i class="fas {{ $tipoticket->estado ? 'fa-check' : 'fa-times' }} mr-1"></i>
                                {{ $tipoticket->estado ? 'Activo' : 'Inactivo' }}
                            </button>
                        </td>
                        <td class="text-center">
                            <a href="#" class="btn btn-info btn-action mx-1" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-action mx-1 btn-delete" title="Eliminar">
                                <i class="fas fa-trash-alt"></i>
                            </button>
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
    /* Estilos para los botones de estado */
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
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .btn-status i {
        font-size: 0.9rem;
    }
    
    /* Estilos para los botones de acción */
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

    // Manejo del cambio de estado (solo para botones de estado)
    $('.btn-status').click(function(e) {
        e.preventDefault();
        const button = $(this);
        const id = button.data('id');
        const currentEstado = parseInt(button.data('estado'));
        const newEstado = currentEstado ? 0 : 1;
        
        // Animación de cambio
        button.addClass('animate__animated animate__pulse');
        
        // Actualización visual
        setTimeout(() => {
            button.removeClass('animate__animated animate__pulse btn-success btn-danger')
                  .addClass(newEstado ? 'btn-success' : 'btn-danger')
                  .data('estado', newEstado)
                  .html(`<i class="fas ${newEstado ? 'fa-check' : 'fa-times'} mr-1"></i> ${newEstado ? 'Activo' : 'Inactivo'}`);
        }, 300);

        // Aquí iría tu llamada AJAX para actualizar el estado en el servidor
        /*
        $.ajax({
            url: '/tipotickets/' + id + '/status',
            method: 'PATCH',
            data: { estado: newEstado },
            success: function(response) {
                toastr.success('Estado actualizado correctamente');
            },
            error: function() {
                toastr.error('Error al actualizar el estado');
                // Revertir visualmente si hay error
                button.removeClass('animate__animated animate__pulse btn-success btn-danger')
                      .addClass(currentEstado ? 'btn-success' : 'btn-danger')
                      .data('estado', currentEstado)
                      .html(`<i class="fas ${currentEstado ? 'fa-check' : 'fa-times'} mr-1"></i> ${currentEstado ? 'Activo' : 'Inactivo'}`);
            }
        });
        */
    });

    // Manejo del botón eliminar (solo para botones con clase btn-delete)
    $('.btn-delete').click(function(e) {
        e.preventDefault();
        if(confirm('¿Estás seguro de eliminar este registro?')) {
            // Aquí iría tu código para eliminar
            const button = $(this);
            const id = button.closest('tr').find('.btn-status').data('id');
            /*
            $.ajax({
                url: '/tipotickets/' + id,
                method: 'DELETE',
                success: function(response) {
                    button.closest('tr').fadeOut(300, function() {
                        $(this).remove();
                    });
                    toastr.success('Registro eliminado correctamente');
                },
                error: function() {
                    toastr.error('Error al eliminar el registro');
                }
            });
            */
        }
    });
});
</script>
@endpush
@endsection