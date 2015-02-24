<?php namespace App;

use App\Interfaces\DecimalInterface;

/**
 * App\DetalleArticulo
 *
 * @property integer $id 
 * @property integer $articulo_presupuesto_id 
 * @property integer $proveedor_id 
 * @property float $costo_compra 
 * @property boolean $ind_confirmado 
 * @property string $fecha_pago 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \App\ArticuloPresupuesto $articuloPresupuesto 
 * @property-read \App\Persona $proveedor 
 * @property-read mixed $estatus_display 
 * @method static \Illuminate\Database\Query\Builder|\App\DetalleArticulo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DetalleArticulo whereArticuloPresupuestoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DetalleArticulo whereProveedorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DetalleArticulo whereCostoCompra($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DetalleArticulo whereIndConfirmado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DetalleArticulo whereFechaPago($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DetalleArticulo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\DetalleArticulo whereUpdatedAt($value)
 */
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

    public function removerProveedor(){
        $this->costo_compra = null;
        $this->ind_confirmado = false;
        $this->proveedor_id = null;
        $this->save();
    }

    public function tratarAsignarProveedor($interno = true){
        $presupuesto = $this->articuloPresupuesto->presupuesto;
        $proveedores = $this->articuloPresupuesto->articulo->proveedoresDisponibles($presupuesto->fecha_montaje, $presupuesto->fecha_evento, $interno);
        if($proveedores->count()>0){
            $proveedor = $proveedores->first();
            $this->proveedor_id = $proveedor->id;
            $this->costo_compra = $proveedor->articuloProveedor()->whereArticuloId($this->articuloPresupuesto->articulo_id)->first()->costo_compra;
            $this->ind_confirmado = true;
        }else if($interno){
            $this->tratarAsignarProveedor(false);
        }
        $this->save();
    }
}
