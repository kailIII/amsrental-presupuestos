@extends('layouts.master')

@section('contenido')
<div class="col-md-4 col-md-offset-3">
    <div class="login-panel panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Inicio de sesión</h3>
        </div>
        <div class="panel-body">
            @include('templates.errores')
            {!!Form::model(new App\User(), ['url'=>'auth/login','role'=>'form'])!!}
            {!!Form::simple('email')!!}
            {!!Form::simple('password', 12, 'password')!!}
            <input type="submit" class="btn btn-lg btn-primary btn-block" value="Iniciar Sesión">
            {!!Form::close()!!}
        </div>
    </div>
</div>
@endsection
