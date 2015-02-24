<table class="table jqueryTable responsive" id="asignados">
    <thead>
    <tr>
        <th>Proveedor</th>
        <th>RIF</th>
        <th>Teléfonos</th>
        <th>Asignar</th>
    </tr>
    </thead>
    <tbody>
    @foreach($proveedores as $proveedor)
        <tr data-id="{{$proveedor->id}}" data-detalle_id="{{$detalle_id}}">
            <td>{{$proveedor->nombre}}</td>
            <td>{{$proveedor->rif}}</td>
            <td>{!!$proveedor->telefonos!!}</td>
            <td><a class="btn btn-primary btn-xs usar-proveedor" href="#" title="Usar este proveedor"><i class="fa fa-check"></i></a></td>
        </tr>
    @endforeach
    </tbody>
</table>