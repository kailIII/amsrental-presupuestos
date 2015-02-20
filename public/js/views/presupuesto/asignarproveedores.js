$(function () {
    $(document).on('click','.asignar-proveedor', asignarProveedor);
    documentoListo();
});

function documentoListo() {

}

function asignarProveedor(evt){
    evt.preventDefault();
    var articulo_id = $(evt.target).closest('tr').data('id');
    $('#lista-proveedores').load(baseUrl+'articulos/proveedores-disponibles/'+articulo_id);
}

function agregarArticulo(articulo_id) {
    var data = {
        id: presupuesto_id,
        articulo_id: articulo_id,
    };
    $.post(baseUrl + 'presupuestos/agregararticulo', data, refrescarListado);
}

function eliminarArticulo(idArtPre){
    $.ajax(baseUrl+'presupuestos/articulo/'+idArtPre, {
        type:"DELETE",
        success: refrescarListado
    })
}

function refrescarListado(data){
    mostrarMensaje(data.mensaje);
    var container = $(data.vista).find('#listado');
    $('#listado').html(container.html());
    documentoListo();
}

function actualizarArticulo(evt){
    var data = $(evt.target).closest('tr').find('input').serialize();
    $.post(baseUrl + 'presupuestos/actualizararticulo', data, function(data){
        $('#sub_total').autoNumeric('set',data.presupuesto.sub_total);
        $('#monto_excento').autoNumeric('set',data.presupuesto.monto_excento);
        $('#monto_iva').autoNumeric('set',data.presupuesto.monto_iva);
        $('#monto_total').autoNumeric('set',data.presupuesto.monto_total);
        $(evt.target).closest('tr').find('.costo_total').autoNumeric('set',data.articulo.costo_total);
    });
}

function ordenarFilas(){
    var data = [];
    var cont = 1;
    $('#asignados tbody').find('tr').each(function(){
        data.push({id:$(this).data('id'), orden: cont});
        cont++;
    });
    var json = JSON.stringify(data);
    $.post(baseUrl + 'presupuestos/ordenar', {filas:json});
}