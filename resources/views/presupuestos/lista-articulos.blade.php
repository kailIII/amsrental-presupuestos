<div class="col-md-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-cubes fa-fw"></i> Listado de articulos en el presupuesto
        </div>
        <div class="panel-body">
            <table class="table jqueryTable responsive" id="asignados">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Articulo</th>
                        <th>Cant</th>
                        <th>Dias</th>
                        <th>Costo unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articulosPre as $atrPresupuesto)
                    <tr data-id="{{$atrPresupuesto->id}}">
                        <td>{{$atrPresupuesto->articulo_id}}</td>
                        <td>{!!Form::hidden('id', $atrPresupuesto->id)!!}
                            {{$atrPresupuesto->articulo->nombre}}
                            {!!Form::simple2($atrPresupuesto, 'descripcion',12,'text', ['style'=>'width: 100%;'])!!}
                        </td>
                        <td>{!!Form::simple2($atrPresupuesto, 'cantidad',12,'text', ['style'=>'width: 100%;'])!!}</td>
                        <td>{!!Form::simple2($atrPresupuesto, 'dias',12,'text', ['style'=>'width: 100%;'])!!}</td>
                        <td>{!!Form::simple2($atrPresupuesto, 'costo_venta',12,'text', ['style'=>'width: 100%;'])!!}</td>
                        <td class="decimal-format costo_total">{{$atrPresupuesto->costo_total}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3"></th>
                        <th colspan="2" class="text-right">Sub Total</th>
                        <th class="decimal-format" id="sub_total">{{$presupuesto->sub_total}}</th>
                    </tr>
                    <tr>
                        <th colspan="3"></th>
                        <th colspan="2" class="text-right">Monto Excento</th>
                        <th class="decimal-format" id="monto_excento">{{$presupuesto->monto_excento}}</th>
                    </tr>
                    <tr>
                        <th colspan="3"></th>
                        <th colspan="2" class="text-right">IVA {{$presupuesto->impuesto}}%</th>
                        <th class="decimal-format" id="monto_iva">{{$presupuesto->monto_iva}}</th>
                    </tr>
                    <tr>
                        <th colspan="3"></th>
                        <th colspan="2" class="text-right">Monto Total</th>
                        <th class="decimal-format" id="monto_total">{{$presupuesto->monto_total}}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>