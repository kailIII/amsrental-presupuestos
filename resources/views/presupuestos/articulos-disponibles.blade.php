<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-cubes fa-fw"></i> Listado de articulos disponibles.
        </div>
        <div class="panel-body">
            {!!HTML::simpleTable($articulos, 'App\\Articulo',[],'articulos')!!}
        </div>
    </div>
</div>