$(function () {
    $(document).on('click','a.asignar-proveedor', asignarProveedor);
    $(document).on('click','a.quitar-proveedor', eliminarProveedor);
    $(document).on('click','a.usar-proveedor', usarProveedor);
    $(document).on('blur','input[name="costo_compra"]', actualizarCostoCompra);
});

function actualizarCostoCompra(evt){
    evt.preventDefault();
    var data = {
        id:$(evt.target).closest('tr').data('id'),
        costo_compra:$(evt.target).val()
    };
    $.ajax(baseUrl+'detalle-articulos/actualizarcosto', {
        type:"POST",
        data:data
    });
}

function asignarProveedor(evt){
    evt.preventDefault();
    var detalle_id = $(evt.target).closest('tr').data('id');
    $('#lista-proveedores').load(baseUrl+'detalle-articulos/proveedoresdisponibles/'+detalle_id);
}

function eliminarProveedor(evt){
    evt.preventDefault();
    var detalle_id = $(evt.target).closest('tr').data('id');
    $.ajax(baseUrl+'detalle-articulos/asignarproveedores/'+detalle_id, {
        type:"DELETE",
        success:function(data){
            mostrarMensaje(data.mensaje);
            $('#fila-principal').html($(data.vista).find('#fila-principal').html());
        }
    });
}

function usarProveedor(evt){
    evt.preventDefault();
    var data = {
        id:$(evt.target).closest('tr').data('id'),
        detalle_id:$(evt.target).closest('tr').data('detalle_id')
    };
    $.ajax(baseUrl+'detalle-articulos/asignarproveedores', {
        type:"POST",
        data:data,
        success:function(data){
            mostrarMensaje(data.mensaje);
            $('#fila-principal').html($(data.vista).find('#fila-principal').html());
        }
    });
}