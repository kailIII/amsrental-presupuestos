<?php

namespace App;

/**
 * App\Persona
 *
 * @property integer $id 
 * @property string $rif 
 * @property string $nombre 
 * @property string $correo 
 * @property string $telefono_oficina 
 * @property string $telefono_fax 
 * @property string $telefono_otro 
 * @property string $direccion 
 * @property boolean $ind_externo 
 * @property string $tipo 
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read mixed $telefonos 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ArticuloProveedor[] $articuloProveedor 
 * @property-read mixed $estatus_display 
 * @method static \Illuminate\Database\Query\Builder|\App\Persona whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Persona whereRif($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Persona whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Persona whereCorreo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Persona whereTelefonoOficina($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Persona whereTelefonoFax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Persona whereTelefonoOtro($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Persona whereDireccion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Persona whereIndExterno($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Persona whereTipo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Persona whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Persona whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Persona whereUpdatedAt($value)
 * @method static \App\Persona filtrar($tipo)
 */
class Persona extends BaseModel implements Interfaces\SimpleTableInterface {

    protected $table = "personas";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'rif', 'nombre', 'correo', 'telefono_oficina', 'telefono_fax', 'telefono_otro', 'direccion', 'ind_externo', 'tipo'
    ];

    protected function getRules(){
        return [
            'rif' => 'required',
            'nombre' => 'required',
            'correo' => 'email',
            'telefono_oficina' => 'required|max:20|min:10|regex:/^[0-9.-]*$/',
            'telefono_fax' => 'max:14|min:10|regex:/^[0-9.-]*$/',
            'telefono_otro' => 'max:14|min:10|regex:/^[0-9.-]*$/',
            'direccion' => 'required',
            'ind_externo' => '',
            'tipo' => 'required',
        ];
    }

    protected function getPrettyFields() {
        return [
            'rif' => 'RIF',
            'nombre' => 'Nombre',
            'correo' => 'Correo Electrónico',
            'telefonos' => 'Teléfonos',
            'telefono_oficina' => 'Teléfono Oficina',
            'telefono_fax' => 'Teléfono Fax',
            'telefono_otro' => 'Teléfono Otro',
            'direccion' => 'Dirección',
            'ind_externo' => '¿Proveedor Externo?',
            'tipo' => 'Tipo',
        ];
    }

    public function getTelefonosAttribute() {
        $telefonos = "";
        if ($this->telefono_oficina != "") {
            $telefonos.="Oficina: " . $this->telefono_oficina . '<br>';
        }
        if ($this->telefono_fax != "") {
            $telefonos.="Fax: " . $this->telefono_fax . '<br>';
        }
        if ($this->telefono_otro != "") {
            $telefonos.="Otro: " . $this->telefono_otro;
        }
        return $telefonos;
    }

    public function getPrettyName() {
        return "personas";
    }

    public function scopeFiltrar($query, $tipo) {
        return $query->whereTipo($tipo);
    }

    public function getTableFields() {
        return [
            'rif', 'nombre', 'telefonos','correo'
        ];
    }

    public function articuloProveedor() {
        return $this->hasMany('App\ArticuloProveedor', 'proveedor_id')->with('proveedor');
    }

    public static function comboClientes(){
        $combo = Persona::filtrar('C')->get()->lists('nombre','id');
        $combo[''] = 'Seleccione';
        return $combo;

    }
}
