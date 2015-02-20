@extends('layouts.master')

@section('contenido')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Usuarios</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                @include('templates.tituloBarra',array('obj'=>$usuario, 'titulo'=>'usuario'))
            </div>
            <div class="panel-body">
                @include('templates.errores')
                {!!Form::model($usuario, array('url'=>'usuarios/modificar'))!!}
                {!!Form::hidden('id')!!}
                <div class="row">
                    {!!Form::simple('name', 4)!!}
                    {!!Form::simple('email', 4)!!}
                    {!!Form::simple('password', 4, 'password')!!}
                </div>
                {!!Form::submitBt()!!}
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>
@endsection