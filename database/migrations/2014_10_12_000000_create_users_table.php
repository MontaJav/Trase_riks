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
        Schema::create('Autentifikacija', function (Blueprint $table) {
            $table->id('ID_aut');
            $table->string('lietotajvards')->unique();
            $table->string('parole');
        });

        Schema::create('Lietotajs', function (Blueprint $table) {
            $table->id('ID_lietotajs');
            $table->foreignId('ID_aut')->references('ID_aut')->on('Autentifikacija');
            $table->string('vards');
            $table->string('uzvards');
            $table->timestamp('regDatLiet');
            $table->string('tiesibas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Lietotajs');
        Schema::dropIfExists('Autentifikacija');
    }
};
