<?php namespace App\Providers;

use App\Articulo;
use App\ArticuloPresupuesto;
use App\ArticuloProveedor;
use App\Configuracion;
use App\DetalleArticulo;
use App\Events\Models\ArticuloPresupuestoObserver;
use App\Events\Models\BaseObserver;
use App\Persona;
use App\Presupuesto;
use App\TipoArticulo;
use App\User;
use Illuminate\Support\ServiceProvider;

class ObserversServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Articulo::observe(new BaseObserver());
        ArticuloPresupuesto::observe(new ArticuloPresupuestoObserver());
        ArticuloProveedor::observe(new BaseObserver());
        Configuracion::observe(new BaseObserver());
        DetalleArticulo::observe(new BaseObserver());
        Persona::observe(new BaseObserver());
        Presupuesto::observe(new BaseObserver());
        TipoArticulo::observe(new BaseObserver());
        User::observe(new BaseObserver());
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
