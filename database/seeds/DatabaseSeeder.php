<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();
        $this->call('TipoArticuloTableSeeder');
        $this->call('ConfiguracionTableSeeder');
        $this->call('UsuariosTableSeeder');
        $this->call('ArticulosTableSeeder');
    }

}
