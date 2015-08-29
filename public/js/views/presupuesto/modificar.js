$(function () {
    $(document).on('blur','#asignados tr', actualizarArticulo);
    documentoListo();
});

function documentoListo() {
    $("tbody").sortable({
        connectWith: "tbody",
        receive: function (event, ui) {
            var dest = $(event.target).closest('table').attr('id');
            if (dest == "asignados") {
                agregarArticulo($(ui.item).data('id'));
            }else if(dest == "articulos"){
                eliminarArticulo($(ui.item).data('id'));
            }
        },
        update:function(event, ui){
            var dest = $(event.target).closest('table').attr('id');
            if (dest == "asignados") {
                ordenarFilas();
            }
        }
    }).disableSelection();

    $(document).on('change', '#cliente_id', function(){
        var clienteId = $(this).val();
        if(clienteId != ""){
            $.getJSON(baseUrl+"personas/ajax/"+clienteId, function(data){
                $('#rif').val(data.rif);
                $('#nombre').val(data.nombre);
                $('#correo').val(data.correo);
                $('#telefono_oficina').val(data.telefono_oficina);
                $('#telefono_fax').val(data.telefono_fax);
                $('#telefono_otro').val(data.telefono_otro);
                $('#direccion').val(data.direccion);
            });
        }
    });

  //  $('#cliente_id').trigger('change');
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