<?php

namespace App;

use App\Interfaces\DecimalInterface;

class ArticuloPresupuesto extends BaseModel implements DecimalInterface{

    protected $table = "articulo_presupuesto";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'presupuesto_id', 'articulo_id', 'descripcion', 'cantidad', 'dias', 'costo_venta',
    ];

    /**
     * Reglas que debe cumplir el objeto al momento de ejecutar el metodo save,
     * si el modelo no cumple con estas reglas el metodo save retornará false, y los cambios realizados no haran persistencia.
     * @link http://laravel.com/docs/validation#available-validation-rules
     * @var array
     */
    protected $rules = [
        'presupuesto_id' => 'required|integer',
        'articulo_id' => 'required|integer',
        'descripcion' => '',
        'cantidad' => 'integer',
        'dias' => 'integer',
        'costo_venta' => '',
    ];

    protected $appends = ['costo_total'];
    protected function getRules(){
        return [
            'presupuesto_id' => 'required|integer',
            'articulo_id' => 'required|integer',
            'descripcion' => '',
            'cantidad' => 'integer',
            'dias' => 'integer',
            'costo_venta' => '',
        ];
    }
    protected function getPrettyFields() {
        return [
            'presupuesto_id' => 'Presupuesto',
            'articulo_id' => 'Articulo',
            'descripcion' => 'Descripcion',
            'cantidad' => 'Cantidad',
            'dias' => 'Dias',
            'costo_venta' => 'Costo Unitario',
        ];
    }

    public function getPrettyName() {
        return "articulo_presupuesto";
    }

    /**
     * Define una relación pertenece a Presupuesto
     * @return Presupuesto
     */
    public function presupuesto() {
        return $this->belongsTo('App\Presupuesto');
    }

    /**
     * Define una relación pertenece a Articulo
     * @return Articulo
     */
    public function articulo() {
        return $this->belongsTo('App\Articulo');
    }

    public function detalleArticulos(){
        return $this->hasMany('App\DetalleArticulo');
    }

    public function getCostoTotalAttribute() {
        return $this->dias * $this->costo_venta * $this->cantidad;
    }

    static function getDecimalFields()
    {
        return ['costo_venta','costo_total'];
    }

    public static function ordenar($filas){
        $filas = json_decode($filas);
        foreach($filas as $fila){
            if(isset($fila->id)){
                $art = static::find($fila->id);
                if($art){
                    $art->orden = $fila->orden;
                    $art->save();
                }
            }
        }
    }

    public function savingModel($model){
        if($this->isDirty('cantidad')){
            $actuales = $this->detalleArticulos()->count();
            if($this->cantidad>=$actuales){
                for($i = $actuales; $i<$this->cantidad; $i++){
                    $detalle = DetalleArticulo::create(['articulo_presupuesto_id'=>$this->id]);
                    $detalle->tratarAsignarProveedor();
                }
            }else{
                $detalles = $this->detalleArticulos()->take($actuales-$this->cantidad)->get();
                $detalles->each(function($detalle){
                    $detalle->delete();
                });
                $detalles = $this->detalleArticulos;
                $detalles->each(function($detalle){
                    $detalle->tratarAsignarProveedor();
                });
            }
        }
        return parent::savingModel($model);
    }

    public function deletingModel(){
        $this->detalleArticulos()->delete();
    }
}
