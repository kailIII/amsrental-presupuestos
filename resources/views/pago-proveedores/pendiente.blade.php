@extends('layouts.master')
@section('contenido')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Pago a proveedores.</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-cubes fa-fw"></i>
                    Listado de cuentas por pagar
                </div>
                <div class="panel-body">
                    @include('templates.mensaje')
                    <table class="jqueryTable">
                        <thead>
                        <tr>
                            <th>RIF</th>
                            <th>Proveedor</th>
                            <th>Telefonos</th>
                            <th>Correo</th>
                            <th>Deuda Pendiente</th>
                            <th>Ver Más</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($proveedores as $proveedor)
                            <tr>
                                <td>{{$proveedor->rif}}</td>
                                <td>{{$proveedor->nombre}}</td>
                                <td>{!!$proveedor->telefonos!!}</td>
                                <td>{{$proveedor->correo}}</td>
                                <td>{{\App\Helpers\Helper::tm($proveedor->deuda)}}</td>
                                <td>{!!HTML::link('pago-proveedores/detallependiente/'.$proveedor->id,'',['class'=>'btn btn-xs btn-primary fa fa-plus'])!!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection