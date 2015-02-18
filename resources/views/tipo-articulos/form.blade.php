@extends('layouts.master')

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Tipos de Articulos</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @include('templates.tituloBarra',array('obj'=>$tipo, 'titulo'=>'tipo de articulo'))
            </div>
            <div class="panel-body">
                @include('templates.errores')
                {!!Form::model($tipo, array('url'=>'tipo-articulos/modificar'))!!}
                {!!Form::hidden('id')!!}
                <div class="row">
                    {!!Form::simple('nombre', 10)!!}
                </div>
                {!!Form::submitBt()!!}
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection