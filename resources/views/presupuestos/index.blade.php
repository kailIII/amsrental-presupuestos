@extends('layouts.master')

@section('contenido')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Listado de presupuestos ({{$estatus}})</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-cubes fa-fw"></i>
                    Listado de presupuestos
                </div>
                <div class="panel-body">
                    @include('templates.mensaje')
                    <table class="table bootstrap-datatable jqueryTable responsive">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Evento</th>
                            <th>Lugar</th>
                            <th>Fecha Montaje</th>
                            <th>Fecha Evento</th>
                            <th>Detalle de Costos</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($presupuestos as $presupuesto)
                            <tr>
                                <td>{{$presupuesto->codigo}}</td>
                                <td>{{$presupuesto->cliente->nombre}}</td>
                                <td>{{$presupuesto->nombre_evento}}</td>
                                <td>{{$presupuesto->lugar_evento}}</td>
                                <td>{{$presupuesto->fecha_montaje->format('d/m/Y')}}</td>
                                <td>{{$presupuesto->fecha_evento->format('d/m/Y')}}</td>
                                <td>
                                    <a href="#" data-toggle="tooltip" title="{{$presupuesto->detalle_costos}}">
                                        {{\App\Helpers\Helper::tm($presupuesto->monto_total)}}
                                    </a>
                                </td>
                                <td>{{$presupuesto->estatus_display}}</td>
                                <td>
                                    <a class="btn btn-xs btn-primary fa fa-print"  title="Imprimir" href="{{url('presupuestos/imprimir/'.$presupuesto->id)}}"></a>
                                    <a class="btn btn-xs btn-primary fa fa-envelope abrir-modal"  title="Enviar por correo" href="{{url('presupuestos/enviarcorreo/'.$presupuesto->id)}}"></a>
                                    @if($presupuesto->puedeModificar())
                                        <a class="btn btn-xs btn-primary fa fa-pencil" title="Modificar" href="{{url('presupuestos/modificar/'.$presupuesto->id)}}"></a>
                                    @endif
                                    @if($presupuesto->puedeAnular())
                                        <a class="btn btn-xs btn-danger fa fa-remove" title="Anular" href="{{url('presupuestos/anular/'.$presupuesto->id)}}"></a>
                                    @endif
                                    @if($presupuesto->puedeEnviarCliente())
                                        <a class="btn btn-xs btn-primary fa fa-send" title="Enviado al cliente" href="{{url('presupuestos/enviar/'.$presupuesto->id)}}"></a>
                                    @endif
                                    @if($presupuesto->puedeAprobar())
                                        <a class="btn btn-xs btn-primary fa fa-check" title="Aprobado" href="{{url('presupuestos/aprobado/'.$presupuesto->id)}}"></a>
                                    @endif
                                    @if($presupuesto->puedePagado())
                                        <a class="btn btn-xs btn-primary fa fa-money" title="Pagado" href="{{url('presupuestos/pagado/'.$presupuesto->id)}}"></a>
                                    @endif
                                    @if($presupuesto->puedeReversar())
                                        <a class="btn btn-xs btn-primary fa fa-undo" title="Reversar Pago" href="{{url('presupuestos/reversar/'.$presupuesto->id)}}"></a>
                                    @endif
                                    @if($presupuesto->puedeAsignarProveedor())
                                        <a class="btn btn-xs btn-primary fa fa-list" title="Asignar Proveedores" href="{{url('detalle-articulos/asignarproveedores/'.$presupuesto->id)}}"></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection