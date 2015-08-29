<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticuloTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('articulos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->integer('tipo_articulo_id', false, true);
            $table->boolean('ind_excento');
            $table->softDeletes();
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
        Schema::drop('articulos');
    }

}
