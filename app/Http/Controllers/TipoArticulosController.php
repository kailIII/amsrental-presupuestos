<?php

namespace App\Http\Controllers;

use App\TipoArticulo;
use App\Persona;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\TipoArticuloProveedor;

class TipoArticulosController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function getIndex() {
        $data['tipos'] = TipoArticulo::all();
        return view('tipo-articulos.index', $data);
    }

    public function getModificar($id = 0) {
        $data['tipo'] = TipoArticulo::findOrNew($id);
        return view('tipo-articulos.form', $data);
    }

    public function postModificar(Request $req) {
        $tipo = TipoArticulo::findOrNew($req->get('id', 0));
        $tipo->fill($req->all());
        if ($tipo->save()) {
            return Redirect::to('tipo-articulos')->with('mensaje', 'Se actualizó el tipo de articulo correctamente');
        }
        return Redirect::back()->withInput()->withErrors($tipo->getErrors());
    }

    public function deleteIndex(Request $req) {
        $tipo = TipoArticulo::findOrFail($req->get('id'));
        if ($tipo->delete()) {
            return Redirect::to('tipo-articulos')->with('mensaje', 'Se eliminó el tipo de articulo correctamente');
        }
        return Redirect::back()->withInput()->withErrors($tipo->getErrors());
    }

}
