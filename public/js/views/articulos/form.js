$(function () {
    $(document).on('click', 'a.fa-arrow-right', function () {
        var data = {
            id: $('#id').val(),
            proveedor_id: $(this).data('id'),
            _token: $('input[name="_token"]').val(),
        };
        $.post(baseUrl + 'articulos/asignarproveedor', data, function (data) {
            mostrarMensaje(data.mensaje);
            var container = $(data.vista).find('#asignar-proveedores');
            $('#asignar-proveedores').html(container.html());
        });
    });

    $(document).on('click', 'a.fa-arrow-left', function () {
        var art_id = $(this).data('id');
        $.ajax(baseUrl + 'articulos/asignarproveedor/' + art_id, {
            type: "DELETE",
            success: function (data) {
                mostrarMensaje(data.mensaje);
                var container = $(data.vista).find('#asignar-proveedores');
                $('#asignar-proveedores').html(container.html());
            }
        });
    });

    $(document).on('blur', 'input[name="cantidad"], input[name="costo_compra"]', function () {
        var parentRow = $(this).closest('tr');
        var data = {
            id: $(parentRow).find('#id').val(),
            costo_compra: $(parentRow).find('#costo_compra').val(),
            cantidad: $(parentRow).find('#cantidad').val(),
        };
        $.post(baseUrl + 'articulos/actualizarartproveedor', data, function (data) {
            mostrarMensaje(data.mensaje);
        }).fail(function (data) {
            mostrarError(procesarErrores(data.responseJSON.errores));
        });
    });
});


