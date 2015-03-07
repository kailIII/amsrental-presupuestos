<div class="col-md-6">
    <h4>Asignar Proveedor</h4>
    {!!HTML::simpleTable($proveedores, 'App\\Persona',['arrow-right'=>'Asignar'],'proveedores')!!}
</div>
<div class="col-md-6">
    <h4>Proveedores Asignados</h4>
    <table class="table jqueryTable responsive" id="asignados">
        <thead>
            <tr>
                <th>RIF</th>
                <th>Nombre</th>
                <th>Cant. Disp.</th>
                <th>Costo Unitario</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($proveedoresAsignados as $artProveedor)
            <tr>
                <td>{{$artProveedor->proveedor->rif}}</td>
                <td>{{$artProveedor->proveedor->nombre}}</td>
                <td>{!!Form::simple2($artProveedor, 'cantidad',12,'text', ['style'=>'width: 100%;'])!!}</td>
                <td>{!!Form::simple2($artProveedor, 'costo_compra',12,'text', ['style'=>'width: 100%;'])!!}</td>
                <td>
                    {!!Form::hidden('id', $artProveedor->id, ['id'=>'id'])!!}
                    <a class="btn fa fa-arrow-left" title="Remover" data-id="{{$artProveedor->id}}"></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>