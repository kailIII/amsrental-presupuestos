<?php namespace App;

use App\Interfaces\DecimalInterface;

class DetalleArticulo extends BaseModel implements DecimalInterface{

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
            'costo_compra'=>'',
            'ind_confirmado'=>'',
            'fecha_pago'=>'',
        ];
    }

    protected function getPrettyFields() {
        return [
            'articulo_presupuesto_id'=>'Articulo Presupuesto',
            'proveedor_id'=>'Proveedor',
            'costo_compra'=>'Costo de Compra',
            'ind_confirmado'=>'Confirmado?',
            'fecha_pago'=>'Fecha de Pago',

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
        return $this->belongsTo('App\Persona');
    }

    static function getDecimalFields(){
        return ['costo_compra'];
    }

    public function tratarAsignarProveedor(){
        $presupuesto = $this->articuloPresupuesto->presupuesto;
        $proveedores = $this->articuloPresupuesto->articulo->proveedoresDisponibles($presupuesto->fecha_montaje, $presupuesto->fecha_evento);
        if($proveedores->count()>0){
            $this->proveedor_id = $proveedores->first()->id;
            $this->ind_confirmado = true;
        }else{
            $this->tratarAsignarProveedorExterno();
        }
        $this->save();
    }

    private function tratarAsignarProveedorExterno(){
        $presupuesto = $this->articuloPresupuesto->presupuesto;
        $proveedores = $this->articuloPresupuesto->articulo->proveedoresDisponibles($presupuesto->fecha_montaje, $presupuesto->fecha_evento, false);
        if($proveedores->count()>0){
            $this->proveedor_id = $proveedores->first()->id;
            $this->ind_confirmado = true;
        }
    }
}
