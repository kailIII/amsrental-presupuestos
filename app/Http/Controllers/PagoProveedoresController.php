<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\DetalleArticulo;
use App\Persona;
use Illuminate\Http\Request;

class PagoProveedoresController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getPendiente()
    {
        $callback = function ($query) {
            $query->whereNull('fecha_pago');
        };
        $data['proveedores'] = Persona::with('articulosVendidos')
            ->externos()
            ->whereHas('articulosVendidos', $callback)->get();

        return view('pago-proveedores.pendiente', $data);
    }

    public function getPagado()
    {
        $callback = function ($query) {
            $query->whereNotNull('fecha_pago');
        };
        $data['proveedores'] = Persona::with('articulosVendidos')
            ->externos()
            ->whereHas('articulosVendidos', $callback)->get();

        return view('pago-proveedores.pagado', $data);
    }

    public function getDetallepagado($id)
    {
        $detalles = DetalleArticulo::whereProveedorId($id)->whereNotNull('fecha_pago')->get();
        $proveedor = Persona::findOrFail($id);

        return view('pago-proveedores.detallepagado', compact('detalles', 'proveedor'));
    }

    public function getDetallependiente($id)
    {
        $detalles = DetalleArticulo::whereProveedorId($id)->whereNull('fecha_pago')->get();
        $proveedor = Persona::findOrFail($id);

        return view('pago-proveedores.detallependiente', compact('detalles', 'proveedor'));
    }

    public function postDetallependiente(Request $req)
    {
        $proveedor_id = $req->get('proveedor_id');
        DetalleArticulo::marcarPagados($req->get('detalle_id', []));

        return redirect('pago-proveedores/detallependiente/' . $proveedor_id)->with('mensaje',
            'Se marcaron los articulos como pagados correctamente');
    }

    public function postDetallepagado(Request $req)
    {
        $proveedor_id = $req->get('proveedor_id');
        DetalleArticulo::marcarDevueltos($req->get('detalle_id', []));

        return redirect('pago-proveedores/detallepagado/' . $proveedor_id)->with('mensaje',
            'Se marcaron los articulos como no pagados correctamente');
    }
}
