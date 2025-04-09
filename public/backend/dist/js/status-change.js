// public/js/statuschange.js
$(document).ready(function() {
    // Configuración de Toastr (opcional)
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };

    // Manejador del evento change para los switches
    $(document).on('change', '.toggle-class', function() {
        const checkbox = $(this);
        const isChecked = checkbox.prop('checked');
        const elementId = checkbox.data('id');
        const elementType = checkbox.data('type');
        const label = checkbox.next('.custom-control-label');

        // Configuración de la petición AJAX
        const requestData = {
            estado: isChecked ? 1 : 0,
            _token: $('meta[name="csrf-token"]').attr('content'),
            _method: 'PATCH'
        };

        // Actualización visual inmediata
        label.text(isChecked ? 'Activo' : 'Inactivo');

        // Petición AJAX
        $.ajax({
            url: `/tipotickets/${elementId}/status`,
            type: 'POST', // Usamos POST por compatibilidad
            dataType: 'json',
            data: requestData,
            success: function(response) {
                toastr.success('Estado actualizado correctamente');
            },
            error: function(xhr) {
                // Revertir cambios visuales en caso de error
                checkbox.prop('checked', !isChecked);
                label.text(!isChecked ? 'Activo' : 'Inactivo');
                
                const errorMessage = xhr.responseJSON?.message || 'Error al actualizar el estado';
                toastr.error(errorMessage);
            }
        });
    });
});