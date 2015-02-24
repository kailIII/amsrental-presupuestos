<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        {!!HTML::link('', 'AMS Rental', ['class'=>'navbar-brand'])!!}
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  {{Auth::user()->name}} <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>{!!HTML::menu('auth/logout','sign-out','Cerrar Sesión')!!}</li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    {!!HTML::menu('','dashboard','Inicio')!!}
                </li>
                <li>
                    <a href="#"><i class="fa fa-file-pdf-o fa-fw"></i> Presupuestos<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            {!!HTML::menu('presupuestos/modificar','plus','Nuevo')!!}
                        </li>
                        <li>
                            {!!HTML::menu('presupuestos','search','Todos')!!}
                        </li>
                        <li>
                            {!!HTML::menu('presupuestos?estatus=1','paint-brush','En Elaboración')!!}
                        </li>
                        <li>
                            {!!HTML::menu('presupuestos?estatus=2','spinner','Esperando Aprobación')!!}
                        </li>
                        <li>
                            {!!HTML::menu('presupuestos?estatus=3','check','Aprobados')!!}
                        </li>
                        <li>
                            {!!HTML::menu('presupuestos?estatus=4','money','Pagados')!!}
                        </li>
                        <li>
                            {!!HTML::menu('presupuestos?estatus=5','dashboard','Anulados')!!}
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-truck fa-fw"></i> Eventos<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            {!!HTML::menu('presupuestos?evento=hoy','dashboard','Hoy')!!}
                        </li>
                        <li>
                            {!!HTML::menu('presupuestos?evento=semana','dashboard','Esta Semana')!!}
                        </li>
                        <li>
                            {!!HTML::menu('presupuestos?evento=mes','dashboard','Este mes')!!}
                        </li>
                        <li>
                            {!!HTML::menu('presupuestos?evento=pasados','dashboard','Pasados')!!}
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Reportes<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            {!!HTML::menu('reportes/cpp','dashboard','Cuentas por Pagar')!!}
                        </li>
                        <li>
                            {!!HTML::menu('reportes/cyp','dashboard','Cuentas ya Pagadas')!!}
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    {!!HTML::menu('personas?tipo=C','male','Clientes')!!}
                </li>
                <li>
                    {!!HTML::menu('personas?tipo=P','institution','Proveedores')!!}
                </li>
                <li>
                    {!!HTML::menu('articulos','cubes','Articulos')!!}
                </li>
                <li>
                    {!!HTML::menu('tipo-articulos','cube','Tipos de Articulos')!!}
                </li>
                <li>
                    {!!HTML::menu('configuraciones','cog','Configuración')!!}
                </li>
                <li>
                    {!!HTML::menu('usuarios','users','Usuarios')!!}
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>