<?php

namespace App;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presupuesto extends BaseModel implements Interfaces\DefaultValuesInterface {

    use SoftDeletes;

    protected $table = "presupuestos";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'cliente_id', 'codigo', 'estatus', 'fecha_evento', 'fecha_montaje', 'nombre_evento', 'lugar_evento', 'impuesto',
    ];

    /**
     * Reglas que debe cumplir el objeto al momento de ejecutar el metodo save, 
     * si el modelo no cumple con estas reglas el metodo save retornará false, y los cambios realizados no haran persistencia.
     * @link http://laravel.com/docs/validation#available-validation-rules
     * @var array
     */

    protected $dates = ['fecha_evento', 'fecha_montaje', 'deleted_at'];
    protected $appends = ['sub_total','monto_excento','monto_total','monto_iva'];

    protected function getRules(){
        return [
            'cliente_id' => 'required|integer',
            'codigo' => 'required',
            'estatus' => 'required|integer',
            'fecha_evento' => 'required|date',
            'fecha_montaje' => 'required|date',
            'nombre_evento' => 'required',
            'lugar_evento' => 'required',
            'impuesto' => 'required',
        ];
    }

    protected function getPrettyFields() {
        return [
            'cliente_id' => 'Cliente',
            'codigo' => 'Codigo de presupuesto',
            'estatus' => 'Estatus',
            'fecha_evento' => 'Fecha del evento',
            'fecha_montaje' => 'Fecha de montaje',
            'nombre_evento' => 'Nombre del evento',
            'lugar_evento' => 'Lugar del evento',
            'impuesto' => 'Impuesto',
        ];
    }

    public static $estatuses = [
        '1'=>'Elaboracion',
        '2'=>'Esperando Aprobacion',
        '3'=>'Aprobados',
        '4'=>'Finalizados',
        '5'=>'Pagados',
        '6'=>'Anulados',
    ];

    public function getPrettyName() {
        return "presupuestos";
    }

    /**
     * Define una relación pertenece a Cliente
     * @return Cliente
     */
    public function cliente() {
        return $this->belongsTo('App\Persona');
    }

    public function articulos() {
        return $this->hasMany('App\ArticuloPresupuesto')->with('articulo')->orderBy('orden');
    }

    public function setFechaEventoAttribute($param) {
        $this->attributes['fecha_evento'] = \Carbon::createFromFormat('d/m/Y', $param);
    }

    public function setFechaMontajeAttribute($param) {
        $this->attributes['fecha_montaje'] = \Carbon::createFromFormat('d/m/Y', $param);
    }

    public function getDefaultValues() {
        $fechaCar = \Carbon::now();
        $numero = Presupuesto::whereRaw('YEAR(created_at)=YEAR(NOW())')->count()+1;
        $codigo = "P-" . $fechaCar->format('my'). '-' . $numero;
        return [
            'estatus' => 1,
            'codigo' =>$codigo,
            'impuesto' => Configuration::get('impuesto'),
        ];
    }

    public function getEstatusDisplayAttribute(){
        return static::$estatuses[$this->estatus];
    }

    public function getSubTotalAttribute(){
        $articulos = $this->articulos;
        $sub_total = 0;
        foreach($articulos as $articulo){
            if(!$articulo->articulo->ind_excento){
                $sub_total += $articulo->costo_total;
            }
        }
        return $sub_total;
    }

    public function getMontoExcentoAttribute(){
        $articulos = $this->articulos;
        $sub_total = 0;
        foreach($articulos as $articulo){
            if($articulo->articulo->ind_excento){
                $sub_total += $articulo->costo_total;
            }
        }
        return $sub_total;
    }

    public function getMontoIvaAttribute(){
        return $this->sub_total * ($this->impuesto/100);
    }

    public function getMontoTotalAttribute(){
        return $this->sub_total+$this->monto_excento+$this->monto_iva;
    }

    public function getDetalleCostosAttribute(){
        $str = "Sub Total: ".Helper::tm($this->sub_total).'<br>';
        $str .= "Monto Excento: ".Helper::tm($this->sub_total).'<br>';
        $str .= "Monto IVA ({$this->impuesto}%): ".Helper::tm($this->sub_total).'<br>';
        $str .= "Monto Total: ".Helper::tm($this->sub_total);
        return $str;
    }

    public function scopeFiltrar($query, $estatus){
        if(!is_null($estatus)){
            return $query->whereEstatus($estatus);
        }
        return $query;
    }

    public function scopeCargar($query){
        return $query->with('cliente');
    }

    public function enviado(){
        $this->cambiarEstatus(1,2);
    }

    public function aprobado(){
        $this->cambiarEstatus(2,3);
    }

    public function finalizado(){
        $this->cambiarEstatus(3,4);
    }

    public function pagado(){
        $this->cambiarEstatus(4,5);
    }

    public function reversar(){
        $this->cambiarEstatus(5,4);
    }

    public function puedeModificar(){
        return $this->estatus == 1 || !isset($this->id);
    }

    public function puedeEnviarCliente(){
        return $this->estatus == 1;
    }

    public function puedeAprobar(){
        return $this->estatus == 2;
    }

    public function puedePagado(){
        return $this->estatus == 3;
    }

    public function puedeReversar(){
        return $this->estatus == 4;
    }

    private function cambiarEstatus($necesario, $nuevo){
        if($this->estatus==$necesario){
            $this->estatus = $nuevo;
        }
        $this->save();
    }

}
