@extends('layouts.master')

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Configuración del sistema</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-cogs fa-fw"></i>
                Parámetros del sistema
            </div>
            <div class="panel-body">
                @include('templates.mensaje')
                {!!HTML::tableModel($configuraciones, 'App\\Configuracion', false, true, false)!!}
            </div>
        </div>
    </div>
</div>
@endsection