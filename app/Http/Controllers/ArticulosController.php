<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\ArticuloProveedor;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class ArticulosController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function getIndex()
    {
        $data['articulos'] = Articulo::eagerLoad()->get();

        return view('articulos.index', $data);
    }

    public function getModificar($id = 0)
    {
        $data['articulo'] = Articulo::findOrNew($id);
        $data['proveedores'] = Persona::filtrar('P')->get();
        $data['proveedoresAsignados'] = $data['articulo']->articuloProveedor;

        return view('articulos.form', $data);
    }

    public function postModificar(Request $req)
    {
        $articulo = Articulo::findOrNew($req->get('id', 0));
        $articulo->fill($req->all());
        if ($articulo->save()) {
            return Redirect::to('articulos')->with('mensaje', 'Se actualizó el articulo correctamente');
        }

        return Redirect::back()->withInput()->withErrors($articulo->getErrors());
    }

    public function deleteIndex(Request $req)
    {
        $articulo = Articulo::findOrFail($req->get('id'));
        if ($articulo->delete()) {
            return Redirect::to('articulos')->with('mensaje', 'Se eliminó el articulo correctamente');
        }

        return Redirect::back()->withInput()->withErrors($articulo->getErrors());
    }

    public function postAsignarproveedor(Request $req)
    {
        $articulo = Articulo::findOrFail($req->get('id'));
        $proveedor = Persona::findOrFail($req->get('proveedor_id'));
        $artProveedor = new ArticuloProveedor();
        $artProveedor->articulo()->associate($articulo);
        $artProveedor->proveedor()->associate($proveedor);
        $artProveedor->save();
        $data['mensaje'] = 'Se asignó el proveedor al artículo correctamente';
        $data['vista'] = $this->getModificar($req->get('id'))->render();

        return response()->json($data);
    }

    public function deleteAsignarproveedor($artproid)
    {
        $artpro = ArticuloProveedor::findOrFail($artproid);
        $art_id = $artpro->articulo_id;
        $artpro->delete();
        $data['mensaje'] = 'Se eliminó el articulo del proveedor correctamente';
        $data['vista'] = $this->getModificar($art_id)->render();

        return response()->json($data);
    }

    public function postActualizarartproveedor(Request $req)
    {
        $artpro = ArticuloProveedor::findOrFail($req->get('id'));
        $artpro->fill($req->all());
        if ($artpro->save()) {
            $data['mensaje'] = 'Se actualizó el articulo del proveedor correctamente';
            $data['vista'] = $this->getModificar($artpro->articulo_id)->render();

            return response()->json($data);
        }

        return response()->json(['errores' => $artpro->getErrors()]);
    }

}
