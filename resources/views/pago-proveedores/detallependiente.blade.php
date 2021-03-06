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
                    Detalle de la deuda con <b>{{$proveedor->nombre}}</b>
                </div>
                <div class="panel-body">
                    @include('templates.mensaje')
                    {!!Form::open(['url'=>'pago-proveedores/detallependiente'])!!}
                    {!!Form::hidden('proveedor_id',$proveedor->id)!!}
                    <table class="jqueryTable">
                        <thead>
                        <tr>
                            <th>Presupuesto</th>
                            <th>Articulo</th>
                            <th>Descripcion</th>
                            <th>Dias</th>
                            <th>Costo de compra</th>
                            <th>Costo Total</th>
                            <th>¿Pagado?</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($detalles as $detalle)
                            <tr>
                                <td>{{$detalle->articuloPresupuesto->presupuesto->codigo}}</td>
                                <td>{{$detalle->articuloPresupuesto->articulo->nombre}}</td>
                                <td>{{$detalle->articuloPresupuesto->descripcion}}</td>
                                <td>{{$detalle->articuloPresupuesto->dias}}</td>
                                <td>{{\App\Helpers\Helper::tm($detalle->costo_compra)}}</td>
                                <td>{{\App\Helpers\Helper::tm($detalle->costo_total)}}</td>
                                <td>{!!Form::checkbox('detalle_id[]',$detalle->id)!!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Pagados</button>
                    {!!HTML::link('pago-proveedores/pendiente','Volver',['class'=>'btn btn-default'])!!}
                </div>
            </div>
        </div>
    </div>
@endsection