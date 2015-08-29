<?php

namespace App;

use App\Interfaces\DecimalInterface;

/**
 * App\ArticuloPresupuesto
 *
 * @property integer $id
 * @property integer $presupuesto_id
 * @property integer $articulo_id
 * @property string $descripcion
 * @property integer $cantidad
 * @property integer $dias
 * @property integer $orden
 * @property float $costo_venta
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Presupuesto $presupuesto
 * @property-read \App\Articulo $articulo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DetalleArticulo[] $detalleArticulos
 * @property-read mixed $costo_total
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloPresupuesto whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloPresupuesto wherePresupuestoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloPresupuesto whereArticuloId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloPresupuesto whereDescripcion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloPresupuesto whereCantidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloPresupuesto whereDias($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloPresupuesto whereOrden($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloPresupuesto whereCostoVenta($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloPresupuesto whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ArticuloPresupuesto whereUpdatedAt($value)
 */
class ArticuloPresupuesto extends BaseModel implements DecimalInterface
{

    protected $table = "articulo_presupuesto";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'presupuesto_id',
        'articulo_id',
        'descripcion',
        'cantidad',
        'dias',
        'costo_venta',
    ];

    /**
     * Reglas que debe cumplir el objeto al momento de ejecutar el metodo save,
     * si el modelo no cumple con estas reglas el metodo save retornará false, y los cambios realizados no haran
     * persistencia.
     * @link http://laravel.com/docs/validation#available-validation-rules
     * @var array
     */
    protected $rules = [
        'presupuesto_id' => 'required|integer',
        'articulo_id'    => 'required|integer',
        'descripcion'    => '',
        'cantidad'       => 'integer',
        'dias'           => 'integer',
        'costo_venta'    => '',
    ];

    protected $appends = ['costo_total'];

    static function getDecimalFields()
    {
        return ['costo_venta', 'costo_total'];
    }

    public static function ordenar($filas)
    {
        $filas = json_decode($filas);
        foreach ($filas as $fila) {
            if (isset($fila->id)) {
                $art = static::find($fila->id);
                if ($art) {
                    $art->orden = $fila->orden;
                    $art->save();
                }
            }
        }
    }

    /**
     * Define una relación pertenece a Presupuesto
     * @return Presupuesto
     */
    public function presupuesto()
    {
        return $this->belongsTo('App\Presupuesto');
    }

    /**
     * Define una relación pertenece a Articulo
     * @return Articulo
     */
    public function articulo()
    {
        return $this->belongsTo('App\Articulo');
    }

    public function detalleArticulos()
    {
        return $this->hasMany('App\DetalleArticulo');
    }

    public function getCostoTotalAttribute()
    {
        return $this->dias * $this->costo_venta * $this->cantidad;
    }

    protected function getPrettyFields()
    {
        return [
            'presupuesto_id' => 'Presupuesto',
            'articulo_id'    => 'Articulo',
            'descripcion'    => 'Descripcion',
            'cantidad'       => 'Cantidad',
            'dias'           => 'Dias',
            'costo_venta'    => 'Costo Unitario',
        ];
    }

    public function getPrettyName()
    {
        return "articulo_presupuesto";
    }

    protected function getRules()
    {
        return [
            'presupuesto_id' => 'required|integer',
            'articulo_id'    => 'required|integer',
            'descripcion'    => '',
            'cantidad'       => 'integer',
            'dias'           => 'integer',
            'costo_venta'    => '',
        ];
    }
}
