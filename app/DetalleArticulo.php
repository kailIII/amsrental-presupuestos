<?php namespace App;

class DetalleArticulo extends BaseModel {

    protected $table = "detalle_articulos";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'articulo_presupuesto_id', 'proveedor_id', 'costo_compra', 'ind_confirmado', 'fecha_pago',
    ];

    protected function getRules(){
        return [
            'articulo_presupuesto_id'=>'required|integer',
            'proveedor_id'=>'integer',
            'costo_compra'=>'required',
            'ind_confirmado'=>'required',
            'fecha_pago'=>'',
        ];
    }

    protected function getPrettyFields() {
        return [
            'articulo_presupuesto_id'=>'articulo_presupuesto_id',
            'proveedor_id'=>'proveedor_id',
            'costo_compra'=>'costo_compra',
            'ind_confirmado'=>'ind_confirmado',
            'fecha_pago'=>'fecha_pago',

        ];
    }

    public function getPrettyName() {
        return "detalle_articulos";
    }

    /**
     * Define una relación pertenece a ArticuloPresupuesto
     * @return ArticuloPresupuesto
     */
    public function articuloPresupuesto(){
        return $this->belongsTo('App\ArticuloPresupuesto');
    }
    /**
     * Define una relación pertenece a Proveedor
     * @return Proveedor
     */
    public function proveedor(){
        return $this->belongsTo('App\Proveedor');
    }


}
