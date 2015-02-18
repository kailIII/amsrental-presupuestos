<div class="col-md-6">
    <h4>Asignar Articulo</h4>
    {!!HTML::simpleTable($articulos, 'App\\Articulo',['arrow-right'=>'Asignar'],'articulos')!!}
</div>
<div class="col-md-6">
    <h4>Articulos Asignados</h4>
    <table class="table jqueryTable responsive" id="asignados">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cant. Disp.</th>
                <th>Costo Unitario</th>
                <th>Remover</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articulosAsignados as $artProveedor)
            <tr>
                <td>{{$artProveedor->articulo->nombre}}</td>
                <td>{!!Form::simple2($artProveedor, 'cantidad',12,'text', ['style'=>'width: 100%;'])!!}</td>
                <td>{!!Form::simple2($artProveedor, 'costo_compra',12,'text', ['style'=>'width: 100%;'])!!}</td>
                <td>
                    {!!Form::hidden('id', $artProveedor->id, ['id'=>'id'])!!}
                    <a class="btn fa fa-arrow-left fa-2x" title="Remover" data-id="{{$artProveedor->id}}"></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>