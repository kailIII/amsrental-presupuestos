@extends('layouts.master')

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        @if($presupuesto->id)
        <h1 class="page-header">Modificar presupuesto</h1>
        @else
        <h1 class="page-header">Crear un nuevo presupuesto</h1>
        @endif
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Detalles del presupuesto
            </div>
            <div class="panel-body">
                @include('templates.mensaje')
                {!!Form::model($presupuesto, array('url'=>'presupuestos/modificar'))!!}
                {!!Form::hidden('id')!!}
                <div class="row">
                    {!!Form::simple('cliente_id', 4, 'select', [], $clientes)!!}
                    {!!Form::simple('nombre_evento', 4)!!}
                    {!!Form::simple('lugar_evento', 4)!!}
                </div>
                <div class="row">
                    {!!Form::simple('fecha_montaje', 6)!!}
                    {!!Form::simple('fecha_evento', 6)!!}
                </div>
                {!!Form::submitBt()!!}
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
@if($presupuesto->id)
<div class="row" id='listado'>
    <div id='lista-articulos'>
        @include('presupuestos.lista-articulos')
    </div>
    <div id='articulos-disponibles'>
        @include('presupuestos.articulos-disponibles')
    </div>
</div>
@endif
<script>
    var presupuesto_id = '{{$presupuesto->id}}';
</script>
@endsection
@section('javascript')
{!!HTML::script('js/views/presupuesto/modificar.js')!!}
@endsection