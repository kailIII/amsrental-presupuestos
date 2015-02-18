<?php

use Illuminate\Database\Seeder;
class ConfiguracionTableSeeder extends Seeder {

    public function run() {
        App\Configuration::set('impuesto', 12);
    }

}
