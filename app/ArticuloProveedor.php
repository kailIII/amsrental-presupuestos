<?php

namespace App;

class ArticuloProveedor extends BaseModel {

    protected $table = "articulo_proveedor";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'articulo_id', 'proveedor_id', 'cantidad', 'costo_compra',
    ];

    /**
     * Reglas que debe cumplir el objeto al momento de ejecutar el metodo save, 
     * si el modelo no cumple con estas reglas el metodo save retornará false, y los cambios realizados no haran persistencia.
     * @link http://laravel.com/docs/validation#available-validation-rules
     * @var array
     */
    protected $rules = [
        'articulo_id' => 'required|integer',
        'proveedor_id' => 'required|integer',
        'cantidad' => 'integer',
        'costo_compra' => '',
    ];

    protected function getRules(){
        return [
            'articulo_id' => 'required|integer',
            'proveedor_id' => 'required|integer',
            'cantidad' => 'integer',
            'costo_compra' => '',
        ];
    }

    protected function getPrettyFields() {
        return [
            'articulo_id' => 'Articulo',
            'proveedor_id' => 'Proveedor',
            'cantidad' => 'Cantidad',
            'costo_compra' => 'Costo Unitario',
        ];
    }

    public function getPrettyName() {
        return "articulo_proveedor";
    }

    /**
     * Define una relación pertenece a Articulo
     * @return Articulo
     */
    public function articulo() {
        return $this->belongsTo('App\Articulo');
    }

    /**
     * Define una relación pertenece a Proveedor
     * @return Proveedor
     */
    public function proveedor() {
        return $this->belongsTo('App\Persona');
    }

}
