<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 27-03-2015
 * Time: 07:29 PM
 */

namespace App\Events\Models;


class BaseObserver {

    public function saving($model)
    {
        if (!isset($model->id) && method_exists($model, 'getDefaultValues')) {
            $default = $model->getDefaultValues();
            $model->setRawAttributes(array_merge($default, $model->getAttributes()));
        }
        return $model->validate();
    }
}