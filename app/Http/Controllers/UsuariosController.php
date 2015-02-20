<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsuariosController extends Controller
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

    public function getIndex()
    {
        $data['usuarios'] = User::all();
        return view('usuarios.index', $data);
    }

    public function getModificar($id = 0)
    {
        $data['usuario'] = User::findOrNew($id);
        return view('usuarios.form', $data);
    }

    public function postModificar(Request $req)
    {
        $usuario = User::findOrNew($req->get('id', 0));
        $usuario->fill($req->all());
        if ($req->get('password') != "") {
            $usuario->password = $req->get('password');
        }
        if ($usuario->save()) {
            return redirect('usuarios')->with('mensaje', 'Se actualizó el usuario correctamente');
        }
        return redirect()->back()->withInput()->withErrors($usuario->getErrors());
    }

    public function deleteIndex(Request $req)
    {
        $usuario = User::findOrFail($req->get('id'));
        if ($usuario->delete()) {
            return redirect('usuarios')->with('mensaje', 'Se eliminó el usuario correctamente');
        }
        return redirect()->back()->withInput()->withErrors($usuario->getErrors());
    }
}