<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LaikaUzskaite', function (Blueprint $table) {
            $table->id('ID_laikauzsk');
            $table->foreignId('ID_uzdevums')->references('ID_uzdevums')->on('Uzdevumi');
            $table->foreignId('ID_aut')->references('ID_aut')->on('Autentifikacija');
            $table->timestamp('sakDatLaiks');
            $table->timestamp('beigDatLaiks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LaikaUzskaite');
    }
};
