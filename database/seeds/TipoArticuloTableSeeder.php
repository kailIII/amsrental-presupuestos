<?php

use Illuminate\Database\Seeder;
class TipoArticuloTableSeeder extends Seeder {

    public function run() {
        $tips = array(
            array('nombre' => 'PLANTAS ELECTRICAS'),
            array('nombre' => 'ILUMINACION'),
            array('nombre' => 'ESTRUCTURAS'),
            array('nombre' => 'OTRO'),
        );
        foreach ($tips as $value) {
            App\TipoArticulo::create($value);
        }
    }

}
