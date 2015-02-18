@extends('layouts.master')

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Tipos de Articulos registrados</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-cubes fa-fw"></i>
                Listado de tipos de articulos registrados
            </div>
            <div class="panel-body">
                @include('templates.mensaje')
                {!!HTML::tableModel($tipos, 'App\\TipoArticulo')!!}
            </div>
        </div>
    </div>
</div>
@endsection