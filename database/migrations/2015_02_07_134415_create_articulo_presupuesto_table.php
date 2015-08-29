<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticuloPresupuestoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('articulo_presupuesto', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('presupuesto_id', false, true);
            $table->integer('articulo_id', false, true);
            $table->string('descripcion', 100)->nullable();
            $table->integer('cantidad', false, true)->nullable();
            $table->integer('dias', false, true)->nullable();
            $table->integer('orden')->nullable();
            $table->decimal('costo_venta', 14, 2)->nullable();
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
        Schema::drop('articulo_presupuesto');
    }

}
