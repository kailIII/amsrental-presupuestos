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
                    <i class="fa fa-plus fa-fw"></i> Modificar {{$configuracion->description}}
                </div>
                <div class="panel-body">
                    @include('templates.errores')
                    {!!Form::model($configuracion, array('url'=>'configuraciones/modificar'))!!}
                    {!!Form::hidden('id')!!}
                    <div class="row">
                        @if($configuracion->ind_editor)
                            {!!Form::simple('value', 10, 'textarea', ['class'=>'ckeditor '])!!}
                        @else
                            {!!Form::simple('value', 10)!!}
                        @endif
                    </div>
                    {!!Form::submitBt()!!}
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    {!!HTML::script('js/ckeditor/ckeditor.js')!!}
@endsection