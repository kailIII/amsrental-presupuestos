<?php

namespace App;

/**
 * Description of Serie
 *
 * @author arasm_000
 * @property integer $id
 * @property string $variable
 * @property string $value
 * @property string $description
 * @property boolean $ind_editor
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $estatus_display
 * @method static \Illuminate\Database\Query\Builder|\App\Configuracion whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Configuracion whereVariable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Configuracion whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Configuracion whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Configuracion whereIndEditor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Configuracion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Configuracion whereUpdatedAt($value)
 */

class Configuracion extends BaseModel
{

    protected $table = "configuraciones";
    protected $fillable = ['variable', 'value', 'description', 'ind_editor'];

    public static function set($variable, $value, $description = "", $has_editor = false)
    {
        $var = static::whereVariable($variable)->first();
        if ($var == null) {
            $var = static::create(['variable'    => $variable,
                                   'value'       => $value,
                                   'description' => $description,
                                   'ind_editor'  => $has_editor
            ]);
        } else {
            $var->value = $value;
            $var->save();
        }

    }

    public static function get($variable, $description = "")
    {
        $var = static::whereVariable($variable)->first();
        if (!is_object($var)) {
            $var = static::create(['variable' => $variable, 'value' => 'example', 'description' => $description]);
        }

        return $var->value;
    }

    protected function getPrettyFields()
    {
        return [
            'value'       => 'Valor',
            'description' => 'Descripción'
        ];
    }

    public function getPrettyName()
    {
        return "Configuracion";
    }

    protected function getRules()
    {
        return [
            'value' => 'required',
        ];
    }

    public function getTableFields()
    {
        return [
            'description',
            'value'
        ];
    }
}
