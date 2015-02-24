<?php

namespace App;

/**
 * App\ArticuloProveedor
 *
 * @property integer $id 
 * @property integer $articulo_id 
 * @property integer $proveedor_id 
 * @property integer $cantidad 
 * @property float $costo_compra 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \App\Articulo $articulo 
 * @property-read \App\Persona $proveedor 
 * @property-read mixed $estatus_display 
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloProveedor whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloProveedor whereArticuloId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloProveedor whereProveedorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloProveedor whereCantidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloProveedor whereCostoCompra($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloProveedor whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloProveedor whereUpdatedAt($value)
 */
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
