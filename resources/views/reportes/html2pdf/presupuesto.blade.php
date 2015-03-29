<page backcolor="#FEFEFE" backtop="20mm" backbottom="20mm" backleft="20mm" backright="20mm" backimgx="center" backimgy="bottom" backimgw="100%" backtop="0" footer="date;heure;page" style="font-size: 12pt">
    <bookmark title="Lettre" level="0" ></bookmark>
    <br><br><br>
    <table cellspacing="0" style="width: 100%; text-align: right; font-size: 16px">
        <tr>
            <td style="width: 45%; color: #444444;" rowspan="2">
                <img style="width: 100%;" src="{{url('/')}}/images/logo.png" alt="Logo">
            </td>
            <td style="width: 45%; color: #444444;">
                <strong>COTIZACIÓN N° {{$presupuesto->codigo}}</strong>
            </td>
        </tr>
        <tr>
            <td style="width: 45%; color: #444444;">
                <strong>Fecha: {{date('d/m/Y')}}</strong>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 16px">
        <tr>
            <td style="width: 20%;"><strong>Cliente:</strong></td>
            <td style="width: 80%;"><strong>{{$presupuesto->cliente->nombre}}</strong></td>
        </tr>
        <tr style="height: auto;">
            <td style="width: 20%;">Dirección: </td>
            <td style="height: auto;width: 80%;">{{$presupuesto->cliente->direccion}}</td>
        </tr>
        <tr>
            <td style="width: 20%;">Télefono: </td>
            <td>{{$presupuesto->cliente->telefono_oficina}}</td>
        </tr>
        <tr>
            <td style="width: 20%;">Evento: </td>
            <td>{{$presupuesto->nombre_evento}}</td>
        </tr>
        <tr>
            <td style="width: 20%;">Lugar Evento: </td>
            <td>{{$presupuesto->lugar_evento}}</td>
        </tr>
        <tr>
            <td style="width: 20%;">Fecha montaje: </td>
            <td>{{$presupuesto->fecha_montaje->format('d/m/Y')}}</td>
        </tr>
        <tr>
            <td style="width: 20%;">Fecha evento: </td>
            <td>{{$presupuesto->fecha_evento->format('d/m/Y')}}</td>
        </tr>
    </table>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: center; font-size: 10pt;">
        <tr>
            <th style="width: 8%;border-bottom: 1px;border-top: 1px;border-left: 1px;">Código</th>
            <th style="width: 46%;border-bottom: 1px;border-top: 1px;border-left: 1px;">Descripción</th>
            <th style="width: 8%;border-bottom: 1px;border-top: 1px;border-left: 1px;">Cant</th>
            <th style="width: 8%;border-bottom: 1px;border-top: 1px;border-left: 1px;">Dias</th>
            <th style="width: 15%;border-bottom: 1px;border-top: 1px;border-left: 1px;">Precio Unitario</th>
            <th style="width: 15%;border: 1px;">Total Bs.F</th>
        </tr>
        @foreach($presupuesto->articulos as $articulo)
        <tr>
            <td style="width: 8%;border-bottom: 1px;border-left: 1px;">{{$articulo->articulo_id}}</td>
            <td style="width: 46%;border-bottom: 1px;border-left: 1px;">{{$articulo->articulo->nombre}} {{$articulo->descripcion}}</td>
            <td style="width: 8%;border-bottom: 1px;border-left: 1px;">{{$articulo->cantidad}}</td>
            <td style="width: 8%;border-bottom: 1px;border-left: 1px;">{{$articulo->dias}}</td>
            <td style="width: 15%;border-bottom: 1px;border-left: 1px;text-align: right;">{{\App\Helpers\Helper::tm($articulo->costo_venta)}}</td>
            <td style="width: 15%;border-bottom: 1px;border-left: 1px;border-right: 1px;text-align: right;">{{\App\Helpers\Helper::tm($articulo->costo_total)}}</td>
        </tr>
        @endforeach
        <tr><th colspan="6" style="color: white;">ds</th></tr>
        <tr>
            <th colspan="2" style="border: 0px;"></th>
            <th colspan="3" style="border: 1px;">SUB TOTAL BS.F</th>
            <th style="border-top: 1px;border-bottom: 1px;border-right: 1px;text-align: right;">{{\App\Helpers\Helper::tm($presupuesto->sub_total)}}</th>
        </tr>
        <tr>
            <th colspan="2" style="border: 0px;"></th>
            <th colspan="3" style="border-bottom: 1px;border-left: 1px;border-right: 1px;">Monto Excento</th>
            <th style="border-bottom: 1px;border-right: 1px;text-align: right;">{{\App\Helpers\Helper::tm($presupuesto->monto_excento)}}</th>
        </tr>
        <tr>
            <th colspan="2" style="border: 0px;"></th>
            <th colspan="3" style="border-bottom: 1px;border-left: 1px;border-right: 1px;">IVA {{$presupuesto->impuesto}}% BS.F</th>
            <th style="border-bottom: 1px;border-right: 1px;text-align: right;">{{\App\Helpers\Helper::tm($presupuesto->monto_iva)}}</th>
        </tr>
        <tr>
            <th colspan="2" style="border: 0px;"></th>
            <th colspan="3" style="border-bottom: 1px;border-left: 1px;border-right: 1px;">Monto total BS.F</th>
            <th style="border-bottom: 1px;border-right: 1px;text-align: right;">{{\App\Helpers\Helper::tm($presupuesto->monto_total)}}</th>
        </tr>
    </table>
    <br>
    <nobreak>
        {!!\App\Configuracion::get('condiciones_presupuesto')!!}
    </nobreak>
    <page_footer>
        {!!\App\Configuracion::get('footer_presupuesto')!!}
    </page_footer>
</page>