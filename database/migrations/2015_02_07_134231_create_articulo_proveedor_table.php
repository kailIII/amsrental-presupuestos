<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticuloProveedorTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('articulo_proveedor', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('articulo_id', false, true);
            $table->integer('proveedor_id', false, true);
            $table->integer('cantidad', false, true)->nullable();
            $table->decimal('costo_compra', 14, 2)->nullable();
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
        Schema::drop('articulo_proveedor');
    }

}
