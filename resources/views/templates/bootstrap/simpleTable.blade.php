<table class="table responsive jqueryTable" id='{{$table_id or "tabla"}}'>
    <thead>
        <tr>
            @foreach($prettyFields as $col)
            <th>{{$col}}</th>
            @endforeach
            @if(count($botones)>0)
            <th>Acciones</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($collection as $object)
        <tr data-id='{{$object->id}}'>
            @foreach($prettyFields as $key=>$col)
            <td>{!!$object->getValueAt($key)!!}</td>
            @endforeach
            @if(count($botones)>0)
            <td>
                @foreach($botones as $icon => $boton)
                <a class="btn fa fa-{{$icon}} fa-2x" title="{{$boton}}" data-id='{{$object->id}}'></a>
                @endforeach
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>