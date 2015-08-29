<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29-03-2015
 * Time: 10:03 AM
 */

namespace App\Events\Models;

use App\Configuracion;
use Carbon\Carbon;

class PresupuestoObserver extends BaseObserver
{

    public function created()
    {
        $hoy = Carbon::now();
        $proximo = (Configuracion::get('nro-presupuesto-' . $hoy->year) + 1);
        if ($proximo == 1) {
            $proximo = 2;
        }
        Configuracion::set('nro-presupuesto-' . $hoy->year, $proximo,
            'Próximo número de presupuesto para el año ' . $hoy->year);
    }
}