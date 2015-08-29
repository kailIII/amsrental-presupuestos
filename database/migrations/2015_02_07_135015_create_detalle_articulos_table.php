<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleArticulosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('detalle_articulos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('articulo_presupuesto_id', false, true);
            $table->integer('proveedor_id', false, true)->nullable();
            $table->decimal('costo_compra', 14, 2)->nullable();
            $table->boolean('ind_confirmado')->default(0);
            $table->datetime('fecha_pago')->nullable();
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
        Schema::drop('detalle_articulos');
    }

}
