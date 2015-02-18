@extends('layouts.master')

@section('contenido')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{$tipo}}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @include('templates.tituloBarra',array('obj'=>$persona, 'titulo'=>$tipo))
                </div>
                <div class="panel-body">
                    @include('templates.errores')
                    {!!Form::model($persona, array('url'=>'personas/modificar'))!!}
                    {!!Form::hidden('id',$persona->id, ['id'=>'id'])!!}
                    {!!Form::hidden('tipo')!!}
                    <div class="row">
                        {!!Form::simple('rif', 4)!!}
                        {!!Form::simple('nombre', 4)!!}
                        {!!Form::simple('correo', 4)!!}
                    </div>
                    <div class="row">
                        {!!Form::simple('telefono_oficina', 4)!!}
                        {!!Form::simple('telefono_fax', 4)!!}
                        {!!Form::simple('telefono_otro', 4)!!}
                    </div>
                    <div class="row">
                        {!!Form::simple('direccion', 8, 'textarea')!!}
                        @if($persona->tipo=="P")
                            {!!Form::simple('ind_externo', 4)!!}
                        @endif
                    </div>
                    {!!Form::submitBt()!!}
                    {!!Form::close()!!}
                    @if($persona->id && $persona->tipo=="P")
                        <div class="row" id='asignar-articulos'>
                            @include('personas.asignar-articulos')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    {!!HTML::script('js/views/personas/form.js')!!}
@endsection