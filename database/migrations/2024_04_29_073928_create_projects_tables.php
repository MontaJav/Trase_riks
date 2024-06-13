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
        Schema::create('ProjVaditajs', function (Blueprint $table) {
            $table->id('ID_vaditajs');
            $table->string('vards');
            $table->string('uzvards');
            $table->foreignId('ID_aut')->references('ID_aut')->on('Autentifikacija');
            $table->timestamp('regDatVad')->nullable();
        });

        Schema::create('ProjNosaukums', function (Blueprint $table) {
            $table->id('ID_projekts');
            $table->foreignId('ID_vaditajs')->references('ID_vaditajs')->on('ProjVaditajs');
            $table->timestamp('regDatProj');
            $table->string('red_datProj')->nullable();
            $table->string('projNos')->unique();
        });

        Schema::create('ProjLietotaji', function (Blueprint $table) {
            $table->foreignId('ID_lietotajs')->references('ID_lietotajs')->on('Lietotajs');
            $table->foreignId('ID_projekts')->references('ID_projekts')->on('ProjNosaukums');
            $table->timestamp('regDatProj');
            $table->unique(['ID_lietotajs', 'ID_projekts']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ProjLietotaji');
        Schema::dropIfExists('ProjNosaukums');
        Schema::dropIfExists('ProjVaditajs');
    }
};
