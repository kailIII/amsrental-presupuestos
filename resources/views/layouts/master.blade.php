<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
        <meta name="description" content="">
        <meta name="author" content="Nadin Yamaui">

        <title>AMS Rental</title>

        {!!HTML::style('css/bootstrap.min.css')!!}
        {!!HTML::style('bower_components/metisMenu/dist/metisMenu.min.css')!!}
        {!!HTML::style('css/sb-admin-2.css')!!}
        {!!HTML::style('bower_components/font-awesome/css/font-awesome.min.css')!!}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
        <div id="wrapper">
            @if(Auth::check())
            @include('layouts.menu')
            @endif
            <div id="page-wrapper">
                @yield('contenido')
            </div>
        </div>
        <div class="modal fade" id="modalConfirmacion">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Ventana de confirmación</h4>
                    </div>
                    <div class="modal-body">
                        <p id='mensajeModalConfirmacion'></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button id="okModalConfirmacion" type="button" class="btn btn-danger">Si</button>
                    </div>
                </div>
            </div>
        </div>
        <h4><div id="contenedorEspera" class="alert alert-warning navbar-fixed-top" style="display: none;"></div></h4>
        <h4><div id="contenedorCorrecto" class="alert alert-success navbar-fixed-top" style="display: none;"></div></h4>
        <h4><div id="contenedorError" class="alert alert-danger navbar-fixed-top" style="display: none;"></div></h4>
        <div class="modal fade" id="divModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
        <div class="modal fade" id="divModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>

        <script>
            var baseUrl = '{{url("")}}/';
        </script>
        {!!HTML::script('bower_components/jquery/dist/jquery.min.js')!!}
        {!!HTML::script('js/bootstrap.min.js')!!}
        {!!HTML::script('bower_components/metisMenu/dist/metisMenu.min.js')!!}

        {!!HTML::script('js/sb-admin-2.js')!!}

        {!!HTML::script('js/datatables.min.js')!!}
        {!!HTML::script('js/datatables.bootstrap.min.js')!!}
        {!!HTML::script('js/jquery-ui.min.js')!!}
        {!!HTML::script('js/jquery.autoNumeric.min.js')!!}
        {!!HTML::style('css/datatables.bootstrap.min.css')!!}
        {!!HTML::style('css/datatables.min.css')!!}
        {!!HTML::script('js/datepicker.min.js')!!}
        {!!HTML::script('js/locales/bootstrap-datepicker.es.js')!!}
        {!!HTML::style('css/datepicker.min.css')!!}

        @yield('javascript')
    </body>
</html>