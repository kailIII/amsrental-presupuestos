<?php

namespace App;

/**
 * Description of Serie
 *
 * @author arasm_000
 */
use Illuminate\Database\Eloquent\Model;

class Configuracion extends BaseModel {

    protected $table = "configuraciones";
    protected $fillable = ['variable', 'value', 'description', 'ind_editor'];

    public static function set($variable, $value, $description ="", $has_editor = false) {
        $var = static::whereVariable($variable)->first();
        if ($var==null) {
            $var = static::create(['variable' => $variable,'value'=>$value, 'description'=>$description, 'ind_editor'=>$has_editor]);
        }else{
            $var->value = $value;
            $var->save();
        }

    }

    public static function get($variable) {
        $var = static::whereVariable($variable)->first();
        if (!is_object($var)) {
            $var = static::create(['variable' => $variable, 'value' => '']);
        }
        return $var->value;
    }

    public function getTableFields() {
        return [
            'description', 'value'
        ];
    }

    public function getPrettyName()
    {
        return "Configuracion";
    }

    protected function getPrettyFields()
    {
        return [
            'value'=>'Valor',
            'description'=>'Descripción'
        ];
    }

    protected function getRules()
    {
        return [
          'value'=>'required',
        ];
    }
}
