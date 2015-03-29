<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 29-03-2015
 * Time: 10:03 AM
 */

namespace App\Events\Models;


use App\DetalleArticulo;

class ArticuloPresupuestoObserver extends BaseObserver{

    public function saving($model){
        if($model->isDirty('cantidad')){
            $actuales = $model->detalleArticulos()->count();
            if($model->cantidad>=$actuales){
                for($i = $actuales; $i<$model->cantidad; $i++){
                    $detalle = DetalleArticulo::create(['articulo_presupuesto_id'=>$model->id]);
                    $detalle->tratarAsignarProveedor();
                }
            }else{
                $detalles = $model->detalleArticulos()->take($actuales-$model->cantidad)->get();
                $detalles->each(function($detalle){
                    $detalle->delete();
                });
                $detalles = $model->detalleArticulos;
                $detalles->each(function($detalle){
                    $detalle->tratarAsignarProveedor();
                });
            }
        }
        return parent::saving($model);
    }

    public function deleting($model){
        $model->detalleArticulos()->delete();
    }

}