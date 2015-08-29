<?php

namespace App\Http\Controllers;

use App\Configuracion;
use App\ConfiguracionProveedor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class ConfiguracionesController extends Controller
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
        $data['configuraciones'] = Configuracion::all();

        return view('configuraciones.index', $data);
    }

    public function getModificar($id = 0)
    {
        $data['configuracion'] = Configuracion::findOrFail($id);

        return view('configuraciones.form', $data);
    }

    public function postModificar(Request $req)
    {
        $configuracion = Configuracion::findOrFail($req->get('id', 0));
        $configuracion->fill($req->all());
        if ($configuracion->save()) {
            return redirect('configuraciones')->with('mensaje',
                'Se actualizó el ' . $configuracion->description . ' correctamente');
        }

        return Redirect::back()->withInput()->withErrors($configuracion->getErrors());
    }
}
