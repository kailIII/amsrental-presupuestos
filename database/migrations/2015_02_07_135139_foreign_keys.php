<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeys extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('articulos', function(Blueprint $table) {
            $table->index('tipo_articulo_id');
            $table->foreign('tipo_articulo_id')->references('id')->on('tipo_articulos');
        });

        Schema::table('articulo_proveedor', function(Blueprint $table) {
            $table->index('articulo_id');
            $table->index('proveedor_id');
            $table->foreign('articulo_id')->references('id')->on('articulos');
            $table->foreign('proveedor_id')->references('id')->on('personas');
        });

        Schema::table('articulo_presupuesto', function(Blueprint $table) {
            $table->index('presupuesto_id');
            $table->index('articulo_id');
            $table->foreign('presupuesto_id')->references('id')->on('presupuestos');
            $table->foreign('articulo_id')->references('id')->on('articulos');
        });

        Schema::table('detalle_articulos', function(Blueprint $table) {
            $table->index('articulo_presupuesto_id');
            $table->index('proveedor_id');
            $table->foreign('articulo_presupuesto_id')->references('id')->on('articulo_presupuesto');
            $table->foreign('proveedor_id')->references('id')->on('personas');
        });

        Schema::table('presupuestos', function(Blueprint $table) {
            $table->index('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('personas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('articulos', function(Blueprint $table) {
            $table->dropForeign('articulos_tipo_articulo_id_foreign');
            $table->dropIndex('articulos_tipo_articulo_id_index');
        });

        Schema::table('articulo_proveedor', function(Blueprint $table) {
            $table->dropForeign('articulo_proveedor_proveedor_id_foreign');
            $table->dropForeign('articulo_proveedor_articulo_id_foreign');
            
            $table->dropIndex('articulo_proveedor_proveedor_id_index');
            $table->dropIndex('articulo_proveedor_articulo_id_index');
        });

        Schema::table('articulo_presupuesto', function(Blueprint $table) {
            $table->dropForeign('articulo_presupuesto_presupuesto_id_foreign');
            $table->dropForeign('articulo_presupuesto_articulo_id_foreign');
            
            $table->dropIndex('articulo_presupuesto_presupuesto_id_index');
            $table->dropIndex('articulo_presupuesto_articulo_id_index');
        });

        Schema::table('detalle_articulos', function(Blueprint $table) {
            $table->dropForeign('detalle_articulos_proveedor_id_foreign');
            $table->dropForeign('detalle_articulos_articulo_presupuesto_id_foreign');
            $table->dropIndex('detalle_articulos_articulo_presupuesto_id_index');
            $table->dropIndex('detalle_articulos_proveedor_id_index');
        });

        Schema::table('presupuestos', function(Blueprint $table) {
            $table->dropForeign('presupuestos_cliente_id_foreign');
            $table->dropIndex('presupuestos_cliente_id_index');
        });
    }

}
