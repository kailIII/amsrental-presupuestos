<?php

namespace App;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Presupuesto
 *
 * @property integer $id
 * @property integer $cliente_id
 * @property string $codigo
 * @property integer $estatus
 * @property \Carbon\Carbon $fecha_evento
 * @property \Carbon\Carbon $fecha_montaje
 * @property string $nombre_evento
 * @property string $lugar_evento
 * @property float $impuesto
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Persona $cliente
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ArticuloPresupuesto')->with('articulo')->orderBy('orden[]
 *     $articulos
 * @property-read mixed $estatus_display
 * @property-read mixed $sub_total
 * @property-read mixed $monto_excento
 * @property-read mixed $monto_iva
 * @property-read mixed $monto_total
 * @property-read mixed $detalle_costos
 * @method static \Illuminate\Database\Query\Builder|\App\Presupuesto whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Presupuesto whereClienteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Presupuesto whereCodigo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Presupuesto whereEstatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Presupuesto whereFechaEvento($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Presupuesto whereFechaMontaje($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Presupuesto whereNombreEvento($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Presupuesto whereLugarEvento($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Presupuesto whereImpuesto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Presupuesto whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Presupuesto whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Presupuesto whereUpdatedAt($value)
 * @method static \App\Presupuesto filtrar($estatus)
 * @method static \App\Presupuesto cargar()
 * @method static \App\Presupuesto eagerLoad()
 */
class Presupuesto extends BaseModel implements Interfaces\DefaultValuesInterface
{

    use SoftDeletes;

    protected $table = "presupuestos";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'cliente_id',
        'codigo',
        'estatus',
        'fecha_evento',
        'fecha_montaje',
        'nombre_evento',
        'lugar_evento',
        'impuesto',
    ];

    /**
     * Reglas que debe cumplir el objeto al momento de ejecutar el metodo save,
     * si el modelo no cumple con estas reglas el metodo save retornará false, y los cambios realizados no haran
     * persistencia.
     * @link http://laravel.com/docs/validation#available-validation-rules
     * @var array
     */

    protected $dates = ['fecha_evento', 'fecha_montaje', 'deleted_at'];
    protected $appends = ['sub_total', 'monto_excento', 'monto_total', 'monto_iva'];

    protected function getRules()
    {
        return [
            'cliente_id'    => 'required|integer',
            'codigo'        => 'required',
            'estatus'       => 'required|integer',
            'fecha_evento'  => 'required|date' . ($this->fecha_montaje != null ? ('|after:' . $this->fecha_montaje) : ''),
            'fecha_montaje' => 'required|date' . ($this->fecha_evento != null ? ('|before:' . $this->fecha_evento) : ''),
            'nombre_evento' => 'required',
            'lugar_evento'  => 'required',
            'impuesto'      => 'required',
        ];
    }

    protected function getPrettyFields()
    {
        return [
            'cliente_id'    => 'Cliente',
            'codigo'        => 'Codigo de presupuesto',
            'estatus'       => 'Estatus',
            'fecha_evento'  => 'Fecha del evento',
            'fecha_montaje' => 'Fecha de montaje',
            'nombre_evento' => 'Nombre del evento',
            'lugar_evento'  => 'Lugar del evento',
            'impuesto'      => 'Impuesto',
        ];
    }

    public static $estatuses = [
        '1' => 'Elaboracion',
        '2' => 'Esperando Aprobacion',
        '3' => 'Aprobado',
        '4' => 'Articulos Confirmados',
        '5' => 'Pagado',
        '6' => 'Anulado',
    ];

    public function getPrettyName()
    {
        return "presupuestos";
    }

    /**
     * Define una relación pertenece a Cliente
     * @return Cliente
     */
    public function cliente()
    {
        return $this->belongsTo('App\Persona');
    }

    public function articulos()
    {
        return $this->hasMany('App\ArticuloPresupuesto')->with('articulo')->orderBy('orden');
    }

    public function detalles()
    {
        return $this->hasManyThrough('App\DetalleArticulo',
            'App\ArticuloPresupuesto')->with('articuloPresupuesto.articulo');
    }

    public function setFechaEventoAttribute($param)
    {
        try {
            $this->attributes['fecha_evento'] = Carbon::createFromFormat('d/m/Y', $param);
        } catch (\InvalidArgumentException $e) {
            $this->attributes['fecha_evento'] = null;
        }

    }

    public function setFechaMontajeAttribute($param)
    {
        try {
            $this->attributes['fecha_montaje'] = Carbon::createFromFormat('d/m/Y', $param);
        } catch (\InvalidArgumentException $e) {
            $this->attributes['fecha_montaje'] = null;
        }
    }

    public function getDefaultValues()
    {
        $fechaCar = Carbon::now();
        $proximo = Configuracion::get('nro-presupuesto-' . $fechaCar->year);
        if ($proximo == "") {
            $proximo = 1;
        }
        $codigo = "P-" . $fechaCar->format('my') . '-' . $proximo;

        return [
            'estatus'  => 1,
            'codigo'   => $codigo,
            'impuesto' => Configuracion::get('impuesto'),
        ];
    }

    public function getEstatusDisplayAttribute()
    {
        return static::$estatuses[$this->estatus];
    }

    public function getSubTotalAttribute()
    {
        $articulos = $this->articulos;
        $sub_total = 0;
        foreach ($articulos as $articulo) {
            if (!$articulo->articulo->ind_excento) {
                $sub_total += $articulo->costo_total;
            }
        }

        return $sub_total;
    }

    public function getMontoExcentoAttribute()
    {
        $articulos = $this->articulos;
        $sub_total = 0;
        foreach ($articulos as $articulo) {
            if ($articulo->articulo->ind_excento) {
                $sub_total += $articulo->costo_total;
            }
        }

        return $sub_total;
    }

    public function getMontoIvaAttribute()
    {
        return $this->sub_total * ($this->impuesto / 100);
    }

    public function getMontoTotalAttribute()
    {
        return $this->sub_total + $this->monto_excento + $this->monto_iva;
    }

    public function getDetalleCostosAttribute()
    {
        $str = "Sub Total: " . Helper::tm($this->sub_total) . '<br>';
        $str .= "Monto Excento: " . Helper::tm($this->monto_excento) . '<br>';
        $str .= "Monto IVA ({$this->impuesto}%): " . Helper::tm($this->monto_iva) . '<br>';
        $str .= "Monto Total: " . Helper::tm($this->monto_total);

        return $str;
    }

    public function scopeFiltrar($query, $filtros)
    {
        $fecha_desde = Carbon::now();
        if (isset($filtros['estatus'])) {
            $query->whereEstatus($filtros['estatus']);
        }
        if (isset($filtros['evento'])) {
            if ($filtros['evento'] == "hoy") {
                $fecha_hasta = $fecha_desde;
            } else {
                if ($filtros['evento'] == "semana") {
                    $fecha_hasta = Carbon::createFromTimestamp(strtotime('this week', time()))->addDays(6);
                } else {
                    if ($filtros['evento'] == "mes") {
                        $fecha_hasta = $fecha_desde->copy()->lastOfMonth();
                    } else {
                        if ($filtros['evento'] == "pasados") {
                            $fecha_hasta = $fecha_desde->copy()->subDay();
                            $fecha_desde->subYears(100);
                        }
                    }
                }
            }
            $query->where('fecha_evento', '>=', $fecha_desde)->where('fecha_evento', '<=', $fecha_hasta);
        }

        return $query;
    }

    public function enviado()
    {
        $this->cambiarEstatus(1, 2);
    }

    public function aprobado()
    {
        $this->cambiarEstatus(2, 3);
        $this->tratarArticulosConfirmados();
    }

    public function tratarArticulosConfirmados()
    {
        $pendiente = $this->detalles()->whereNull('proveedor_id')->count();
        if ($pendiente == 0) {
            $this->cambiarEstatus(3, 4);
        }
    }

    public function pagado()
    {
        $this->cambiarEstatus(4, 5);
    }

    public function reversar()
    {
        $this->cambiarEstatus(5, 4);
    }

    public function anular()
    {
        $this->cambiarEstatus([1, 2, 3], 6);
    }

    public function puedeModificar()
    {
        return $this->estatus == 1 || !isset($this->id);
    }

    public function puedeEnviarCliente()
    {
        return $this->estatus == 1;
    }

    public function puedeAprobar()
    {
        return $this->estatus == 2;
    }

    public function puedePagado()
    {
        return $this->estatus == 4;
    }

    public function puedeReversar()
    {
        return $this->estatus == 5;
    }

    public function puedeAnular()
    {
        return $this->estatus < 4;
    }

    public function puedeAsignarProveedor()
    {
        return $this->estatus < 6;
    }

    private function cambiarEstatus($necesario, $nuevo)
    {
        if (is_array($necesario) && in_array($this->estatus, $necesario)) {
            $this->estatus = $nuevo;
        } else {
            if ($this->estatus == $necesario) {
                $this->estatus = $nuevo;
            }
        }
        $this->save();
    }

    public function scopeEagerLoad($query)
    {
        return $query->with('cliente')->with('articulos');
    }

}
