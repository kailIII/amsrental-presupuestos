<?php

namespace App\Http\Controllers;

use App\Configuracion;
use App\Configuration;
use App\DetalleArticulo;
use App\Http\Requests\EnviarCorreoRequest;
use App\Persona;
use App\Presupuesto;
use App\Articulo;
use App\ArticuloPresupuesto;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class DetalleArticulosController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getAsignarproveedores($presupuesto_id){
        $data['presupuesto'] = Presupuesto::findOrFail($presupuesto_id);
        $data['detalles'] = $data['presupuesto']->detalles;
        return view('detalle-articulos.asignar-proveedores', $data);
    }

    public function getProveedoresdisponibles($id){
        $detalle = DetalleArticulo::findOrFail($id);
        $presupuesto = $detalle->articuloPresupuesto->presupuesto;
        $articulo = $detalle->articuloPresupuesto->articulo;
        $data['detalle_id'] = $detalle->id;
        $data['proveedores'] = $articulo->proveedoresDisponibles($presupuesto->fecha_montaje, $presupuesto->fecha_evento, false, true);
        return view('detalle-articulos.proveedores-disponibles', $data);
    }

    public function postAsignarproveedores(Request $req){
        $proveedor = Persona::findOrFail($req->get('id'));
        $detalle = DetalleArticulo::findOrFail($req->get('detalle_id'));
        $detalle->proveedor()->associate($proveedor);
        $detalle->save();
        $detalle->articuloPresupuesto->presupuesto->tratarArticulosConfirmados();
        $data['vista'] = $this->getAsignarproveedores($detalle->articuloPresupuesto->presupuesto_id)->render();
        $data['mensaje'] = "Se asignó el proveedor correctamente";
        return response()->json($data);
    }

    public function deleteAsignarproveedores($detalle_id){
        $detalle = DetalleArticulo::findOrFail($detalle_id);
        $detalle->removerProveedor();
        $data['vista'] = $this->getAsignarproveedores($detalle->articuloPresupuesto->presupuesto_id)->render();
        $data['mensaje'] = "Se removió el proveedor correctamente";
        return response()->json($data);
    }

    public function postActualizarcosto(Request $req){
        $detalle = DetalleArticulo::findOrFail($req->get('id'));
        $detalle->fill($req->only('costo_compra'));
        $detalle->save();
        return response()->json();
    }
}
