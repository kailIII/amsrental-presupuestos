@extends('layouts.master')

@section('contenido')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Inicio</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-send fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$cant_presupuestos_enviados}}</div>
                            <div>&iexcl;Presupuestos Enviados!</div>
                        </div>
                    </div>
                </div>
                <a href="{{url('presupuestos?estatus=2')}}">
                    @include('footer_panel')
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-truck fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$cant_eventos_mes}}</div>
                            <div>&iexcl;Eventos este Mes!</div>
                        </div>
                    </div>
                </div>
                <a href="{{url('presupuestos?evento=mes')}}">
                    @include('footer_panel')
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-light-blue">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-check fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$cant_presupuestos_aprobados}}</div>
                            <div>&iexcl;Presupuestos Aprobados!</div>
                        </div>
                    </div>
                </div>
                <a href="{{url('presupuestos?estatus=3')}}">
                    @include('footer_panel')
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><span class="decimal-format">{{$monto_x_cobrar}}</span> Bs.</div>
                            <div>&iexcl;Por Cobrar!</div>
                        </div>
                    </div>
                </div>
                <a href="{{url('presupuestos?estatus=3')}}">
                    @include('footer_panel')
                </a>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-money fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><span class="decimal-format">{{$monto_x_pagar}}</span> Bs.</div>
                            <div>&iexcl;Por Pagar!</div>
                        </div>
                    </div>
                </div>
                <a href="{{url('pago-proveedores/pendiente')}}">
                    @include('footer_panel')
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
@endsection