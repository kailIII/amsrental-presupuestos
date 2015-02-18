<?php

namespace App;

/**
 * Description of Serie
 *
 * @author arasm_000
 */
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model {

    protected $fillable = ['variable', 'value'];

    public static function set($variable, $value) {
        $var = static::whereVariable($variable)->first();
        if (!is_object($var)) {
            $var = static::create(['variable' => $variable, 'value' => $value]);
        }
        $var->value = $value;
        $var->save();
    }

    public static function get($variable) {
        $var = static::whereVariable($variable)->first();
        if (!is_object($var)) {
            $var = static::create(['variable' => $variable, 'value' => '']);
        }
        return $var->value;
    }

    public static function updateMany($values) {
        foreach ($values as $variable => $values) {
            Configuration::set($variable, $values);
        }
    }

}
