<?php

namespace App\Http\Controllers;

use App\DetalleArticulo;
use App\Presupuesto;

class WelcomeController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Welcome Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders the "marketing page" for the application and
      | is configured to only allow guests. Like most of the other sample
      | controllers, you are free to modify or remove it as you desire.
      |
     */

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
    public function index()
    {
        $data['cant_presupuestos_aprobados'] = Presupuesto::where('estatus', '>=', 3)->count();
        $data['cant_presupuestos_enviados'] = Presupuesto::whereEstatus(2)->count();
        $data['cant_eventos_mes'] = Presupuesto::filtrar(['evento' => 'mes'])->count();
        $data['monto_x_pagar'] = DetalleArticulo::whereNull('fecha_pago')->get()->sum('costo_total');
        $presupuestos = Presupuesto::whereEstatus(3)->get();
        $data['monto_x_cobrar'] = 0;
        $presupuestos->each(function (Presupuesto $presupuesto) use ($data) {
            $data['monto_x_cobrar'] += $presupuesto->monto_total;
        });

        return view('index', $data);
    }

}
