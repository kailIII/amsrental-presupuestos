$(document).ajaxComplete(function () {
    $("[id=contenedorEspera]").each(function () {
        $(this).fadeOut(500);
    });
    docReady();
});

$(document).ajaxStart(function () {
    mostrarEspera("Por favor espere.");
});

$.ajaxSetup({
    statusCode: {
        500: function () {
            mostrarError("<span class='fa fa-remove fa-fw'></span> Ocurrio un error al tratar de procesar su solicitud. <i>(Error interno del servidor)</i>");
        },
        401: function () {
            mostrarError("<span class='fa fa-remove fa-fw'></span> Ocurrio un error al tratar de procesar su solicitud. <i>(Es necesaria autenticación)</i>");
        },
        403: function () {
            mostrarError("<span class='fa fa-remove fa-fw'></span> Ocurrio un error al tratar de procesar su solicitud. <i>(El sistema denegó el acceso al recurso)</i>");
        },
        404: function () {
            mostrarError("<span class='fa fa-remove fa-fw'></span> Ocurrio un error al tratar de procesar su solicitud. <i>(Página no encontrada)</i>");
        },
        410: function () {
            mostrarError("<span class='fa fa-remove fa-fw'></span> Ocurrio un error al tratar de procesar su solicitud. <i>(Recurso no encontrado)</i>");
        }
    }
});

$(function () {
    $('#side-menu').metisMenu();
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function () {
    $(window).bind("load resize", function () {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1)
            height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function () {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }

    $(document).on('submit', '.form-eliminar', function (evt) {
        if ($(evt.target).data('confirmed') == undefined) {
            evt.preventDefault();
            var form = evt.target;
            confirmarIntencion("¿Esta seguro que desea eliminar el elemento seleccionado?", function () {
                $(form).attr('data-confirmed', true);
                $(form).submit();
            });
        }
    });
    $(".decimal-format").autoNumeric('init', {
        aSep: ".",
        aDec: ","
    });
    docReady();
});

function docReady() {
    $(".decimal-format").css('text-align', 'right');
    $(".decimal-format").autoNumeric('init', {
        aSep: ".",
        aDec: ","
    });
    $('[data-toggle="tooltip"]').tooltip({html:true});

    $('input, select, textarea').each(function () {
        if ($(this).attr("data-tienetooltip") == undefined && $(this).attr('type') != "radio" && $(this).attr('type') != "hidden") {
            $(this).attr("data-tienetooltip", 1);
           // $(this).tooltip({'trigger': 'focus hover', 'title': $(this).attr("placeholder")});
        }
    });
    $('table.jqueryTable').each(function () {
        if ($(this).attr('data-esdatatable') == undefined) {
            $(this).attr('data-esdatatable', true);
            $(this).DataTable({
                "aaSorting": [],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        }
    });
}

function confirmarIntencion(mensaje, confirmado) {
    $('#modalConfirmacion').modal('show');
    $('#mensajeModalConfirmacion').html(mensaje);
    $('#okModalConfirmacion').unbind('click');
    $('#okModalConfirmacion').click(confirmado);
    $('#okModalConfirmacion').click(function () {
        $('#modalConfirmacion').modal('hide');
    });
}

function mostrarMensaje(mensaje) {
    $("[id=contenedorCorrecto]").each(function () {
        $(this).fadeIn(500);
        $(this).html("<span class='fa fa-check fa-fw'></span> " + mensaje);
    });
    setTimeout(function () {
        $("[id=contenedorCorrecto]").each(function () {
            $(this).fadeOut(500);
        });
    }, 4000);
}

function mostrarEspera(mensaje) {
    $("[id=contenedorEspera]").each(function () {
        $(this).fadeIn(500);
        $(this).html("<img src='" + baseUrl + "images/loader.gif'> " + mensaje);
    });
}
function mostrarError(mensaje) {
    $("[id=contenedorError]").each(function () {
        $(this).fadeIn(500);
        $(this).html(mensaje);
    });
    setTimeout(function () {
        $("[id=contenedorError]").each(function () {
            $(this).fadeOut(500);
        });
    }, 4000);
}

function procesarErrores(errores) {
    var mensaje = "";
    try {
        $.each(errores, function (key, value) {
            $.each(value, function (key2, value2) {
                mensaje += "<span class='glyphicon glyphicon-remove'></span> " + value2 + "</br>";
            });
        });
    } catch (err) {
        return mensaje = "<span class='glyphicon glyphicon-remove'></span> " + errores + "</br>";
    }
    return mensaje;
}
