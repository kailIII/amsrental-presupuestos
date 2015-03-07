<?php

namespace App;

/**
 * App\TipoArticulo
 *
 * @property integer $id
 * @property string $nombre
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\TipoArticulo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoArticulo whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoArticulo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoArticulo whereUpdatedAt($value)
 */
class TipoArticulo extends BaseModel {

    protected $table = "tipo_articulos";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'nombre',
    ];

    protected function getRules(){
        return [
            'nombre' => 'required',
        ];
    }

    protected function getPrettyFields() {
        return [
            'nombre' => 'Tipo de articulo',
        ];
    }

    public function getPrettyName() {
        return "Tipo de articulo";
    }

}
