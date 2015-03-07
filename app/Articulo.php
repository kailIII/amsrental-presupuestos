<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Interfaces\SimpleTableInterface;

/**
 * App\Articulo
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $tipo_articulo_id
 * @property boolean $ind_excento
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\TipoArticulo $tipoArticulo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ArticuloProveedor')->with('proveedor[] $articuloProveedor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Persona[] $proveedores
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Persona[] $proveedoresExternos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Persona[] $proveedoresInternos
 * @property-read mixed $disponibilidad
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Articulo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Articulo whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Articulo whereTipoArticuloId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Articulo whereIndExcento($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Articulo whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Articulo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Articulo whereUpdatedAt($value)
 * @method static \App\Articulo eagerLoad()
 */
class Articulo extends BaseModel implements SimpleTableInterface {

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = "articulos";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'nombre', 'tipo_articulo_id', 'ind_excento',
    ];

    protected function getRules(){
        return [
            'nombre' => 'required',
            'tipo_articulo_id' => 'required|integer',
            'ind_excento' => 'required',
        ];
    }

    protected function getPrettyFields() {
        return [
            'nombre' => 'Nombre',
            'tipo_articulo_id' => 'Tipo de articulo',
            'ind_excento' => 'Excento?',
            'disponibilidad'=>'Disp. del articulo',
        ];
    }

    public function getPrettyName() {
        return "articulo";
    }

    /**
     * Define una relación pertenece a TipoArticulo
     * @return TipoArticulo
     */
    public function tipoArticulo() {
        return $this->belongsTo('App\TipoArticulo');
    }

    public function articuloProveedor() {
        return $this->hasMany('App\ArticuloProveedor')->with('proveedor');
    }

    public function proveedores(){
        return $this->belongsToMany('App\Persona', 'articulo_proveedor', 'articulo_id', 'proveedor_id');
    }

    public function proveedoresExternos() {
        return $this->belongsToMany('App\Persona', 'articulo_proveedor', 'articulo_id', 'proveedor_id')
            ->whereIndExterno(true);
    }

    public function proveedoresInternos() {
        return $this->belongsToMany('App\Persona', 'articulo_proveedor', 'articulo_id', 'proveedor_id')
            ->whereIndExterno(false);
    }

    public function getTableFields() {
        return [
            'nombre', 'tipoArticulo->nombre', 'disponibilidad'
        ];
    }

    public function getDisponibilidadAttribute(){
        return $this->getDisponibilidad(Carbon::now(), Carbon::now());
    }

    public function getDisponibilidad($fecDesde, $fecHasta, $pretty = true, $proveedor = null) {
        $contExterno = $this->proveedoresExternos->count();
        if ($contExterno > 0 && $proveedor == null) {
            return $pretty ? "&infin;" : 99999;
        } else if ($proveedor != null && $proveedor->ind_externo) {
            return $pretty ? "&infin;" : 99999;
        }
        $contPropio = $this->proveedoresInternos->count();
        if ($contPropio == 0) {
            return $pretty ? "No tiene proveedor" : 0;
        } else {
            $cantTotal = $this->proveedoresInternos()->sum('cantidad');

            $cantOcupada = Presupuesto::join('articulo_presupuesto as b', 'presupuestos.id', '=', 'b.presupuesto_id')
                ->join('detalle_articulos as c', 'b.id', '=', 'c.articulo_presupuesto_id')
                ->join('personas as d', 'c.proveedor_id', '=', 'd.id')
                ->where('presupuestos.fecha_montaje','<', $fecHasta->format('Y-m-d'))
                ->where('presupuestos.fecha_evento','>', $fecDesde->format('Y-m-d'))
                ->where('d.ind_externo', '=', false)
                ->where('b.articulo_id', '=', $this->id);
            if ($proveedor != null) {
                $cantOcupada = $cantOcupada->where('c.proveedor_id', '=', $proveedor->id);
            }
            $cantOcupada = $cantOcupada->count('c.articulo_presupuesto_id');
            $cantDisponible = $cantTotal - $cantOcupada;
            return ($pretty ? number_format($cantDisponible, 0, '.', ',') :
                $cantDisponible);
        }
    }

    public function proveedoresDisponibles($fecha_desde, $fecha_hasta, $internos = true, $todos = false){
        $proveedoresDisp = new Collection();
        if($internos && !$todos){
            $proveedores = $this->proveedoresInternos;
        }else if(!$internos && !$todos){
            $proveedores = $this->proveedoresExternos;
        }else{
            $proveedores = $this->proveedores;
        }
        foreach($proveedores as $proveedor){
            if($this->getDisponibilidad($fecha_desde, $fecha_hasta, false, $proveedor)>0){
                $proveedoresDisp->add($proveedor);
            }
        }
        return $proveedoresDisp;
    }

    public function scopeEagerLoad($query){
        return $query->with('tipoArticulo')->with('proveedoresInternos')->with('proveedoresExternos');
    }

}
