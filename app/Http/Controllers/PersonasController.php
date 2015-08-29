<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PersonasController extends Controller
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
    public function getIndex(Request $req)
    {
        $data['personas'] = Persona::filtrar($req->get('tipo'))->get();
        $data['tipo'] = $req->get('tipo') == "P" ? 'Proveedores' : 'Clientes';

        return view('personas.index', $data);
    }

    public function getModificar(Request $req, $id = 0)
    {
        $data['persona'] = Persona::findOrNew($id);
        if ($req->get('tipo', '') != "") {
            $data['persona']->tipo = $req->get('tipo');
        }
        $data['tipo'] = $data['persona']->tipo == "P" ? 'Proveedores' : 'Clientes';
        if ($data['persona']->tipo == "P") {
            $data['articulos'] = Articulo::with('tipoArticulo')->get();
            $data['articulosAsignados'] = $data['persona']->articuloProveedor;
        }

        return view('personas.form', $data);
    }

    public function postModificar(Request $req)
    {
        $persona = Persona::findOrNew($req->get('id', 0));
        $persona->fill($req->all());
        if ($persona->save()) {
            return redirect('personas?tipo=' . $persona->tipo)->with('mensaje',
                'Se actualizó la persona correctamente');
        }

        return Redirect::back()->withInput()->withErrors($persona->getErrors());
    }

    public function deleteIndex(Request $req)
    {
        $persona = Persona::findOrFail($req->get('id'));
        $tipo = $persona->tipo;
        if ($persona->delete()) {
            return redirect('personas?tipo=' . $tipo)->with('mensaje', 'Se eliminó la persona correctamente');
        }

        return Redirect::back()->withInput()->withErrors($persona->getErrors());
    }

    public function getAjax($id)
    {
        $persona = Persona::findOrFail($id);
        return response()->json($persona);
    }

}
