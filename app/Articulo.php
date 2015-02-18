<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Interfaces\SimpleTableInterface;

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

    public function getTableFields() {
        return [
            'nombre', 'tipoArticulo->nombre', 'ind_excento'
        ];
    }

}
