@extends('layouts.master')

@section('contenido')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Asignar Proveedores</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row" id="fila-principal">
        <div class="col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Detalle de articulos del presupuesto
                </div>
                <div class="panel-body">
                    @include('templates.mensaje')
                    <table class="table jqueryTable responsive" id="asignados">
                        <thead>
                        <tr>
                            <th>Articulo</th>
                            <th>Costo Unitario</th>
                            <th>Costo Compra</th>
                            <th>Proveedor</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($detalles as $detalle)
                            <tr data-id="{{$detalle->id}}">
                                <td>{{$detalle->articuloPresupuesto->articulo->nombre}}</td>
                                <td>{{$detalle->articuloPresupuesto->costo_venta}}</td>
                                <td>
                                    @if($presupuesto->puedeAsignarProveedor())
                                        {!!Form::simple2($detalle, 'costo_compra', 12,'text', ['style'=>'width: 100%;'])!!}
                                    @else
                                        {{\App\Helpers\Helper::tm($detalle->costo_compra)}}
                                    @endif
                                </td>
                                <td>
                                    {{$detalle->proveedor->nombre or "No tiene"}}
                                    @if($presupuesto->puedeAsignarProveedor())
                                        @if(!is_object($detalle->proveedor))
                                            <a class="btn btn-primary btn-xs asignar-proveedor" href="#" title="Asignar proveedor"><i class="fa fa-search"></i></a>
                                        @else
                                            <a class="btn btn-danger btn-xs quitar-proveedor" href="#"><i class="fa fa-remove"></i></a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-default" href="{{url('presupuestos')}}"><i class="fa fa-undo"></i> Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Proveedores disponibles
                </div>
                <div class="panel-body" id="lista-proveedores">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    {!!HTML::script('js/views/detalle-articulos/asignar-proveedores.js')!!}
@endsection