<?php

namespace App;

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
        $combo = Persona::filtrar('P')->get()->lists('nombre','id');
        $combo[''] = 'Seleccione';
        return $combo;

    }
}
