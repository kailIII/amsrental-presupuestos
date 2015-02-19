<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationsTabl extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('configuraciones', function(Blueprint $table) {
            $table->increments('id');
            $table->string('variable',50);
            $table->text('value');
            $table->string('description', 100);
            $table->boolean('ind_editor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('configuraciones');
    }

}
