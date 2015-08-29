<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('personas', function(Blueprint $table) {
            $table->increments('id');
            $table->string('rif', 20);
            $table->string('nombre', 100);
            $table->string('correo', 100)->nullable();
            $table->string('telefono_oficina', 20);
            $table->string('telefono_fax', 20)->nullable();
            $table->string('telefono_otro', 20)->nullable();
            $table->string('direccion', 300);
            $table->boolean('ind_externo')->nullable();
            $table->string('tipo', 1);
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
        Schema::drop('personas');
    }

}
