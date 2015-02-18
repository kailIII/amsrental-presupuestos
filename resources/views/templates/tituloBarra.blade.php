@if(isset($obj->id))
<i class="fa fa-edit fa-fw"></i> Modificar {{$titulo}}
@else
<i class="fa fa-plus fa-fw"></i> Agregar {{$titulo}}
@endif