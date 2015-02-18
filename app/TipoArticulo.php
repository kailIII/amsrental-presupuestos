<?php

namespace App;

class TipoArticulo extends BaseModel {

    protected $table = "tipo_articulos";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    protected function getRules(){
        return [
            'nombre' => 'required',
        ];
    }

    protected function getPrettyFields() {
        return [
            'nombre' => 'Tipo de articulo',
        ];
    }

    public function getPrettyName() {
        return "Tipo de articulo";
    }

}
