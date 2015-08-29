<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoArticulosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tipo_articulos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->timestamps();
            $table->engine = "InnoDb";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('tipo_articulos');
    }

}
