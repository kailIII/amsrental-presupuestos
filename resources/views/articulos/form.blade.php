@extends('layouts.master')

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Articulos</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @include('templates.tituloBarra',array('obj'=>$articulo, 'titulo'=>'articulo'))
            </div>
            <div class="panel-body">
                @include('templates.errores')
                {!!Form::model($articulo, array('url'=>'articulos/modificar'))!!}
                {!!Form::hidden('id',$articulo->id, ['id'=>'id'])!!}
                <div class="row">
                    {!!Form::simple('nombre', 4)!!}
                    {!!Form::simple('tipo_articulo_id', 4)!!}
                    {!!Form::simple('ind_excento', 4)!!}
                </div>
                {!!Form::submitBt()!!}
                {!!Form::close()!!}
                @if($articulo->id)
                <div class="row" id='asignar-proveedores'>
                    @include('articulos.asignar-proveedores')
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
{!!HTML::script('js/views/articulos/form.js')!!}
@endsection