<?php

use Illuminate\Database\Seeder;
class UsuariosTableSeeder extends Seeder {

    public function run() {
        $user = new App\User();
        $user->name = "Nadin Yamaui";
        $user->email = "arasmit_yamaui@hotmail.com";
        $user->password = Hash::make('changeme');
        $user->save();
    }

}
