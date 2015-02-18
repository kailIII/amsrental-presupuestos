<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresupuestosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('presupuestos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id', false, true);
            $table->string('codigo', 45);
            $table->integer('estatus', false, true);
            $table->date('fecha_evento');
            $table->date('fecha_montaje');
            $table->string('nombre_evento', 250);
            $table->string('lugar_evento', 250);
            $table->decimal('impuesto', 4, 2);
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('presupuestos');
    }

}
