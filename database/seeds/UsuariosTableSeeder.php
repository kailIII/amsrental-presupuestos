<?php

use Illuminate\Database\Seeder;
class UsuariosTableSeeder extends Seeder {

    public function run() {
        $user = new App\User();
        $user->name = "Samantha Oviedo";
        $user->email = "samyoviedo23@gmail.com";
        $user->password = 'changeme';
        $user->save();
    }

}