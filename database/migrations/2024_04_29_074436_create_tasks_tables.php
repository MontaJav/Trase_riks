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
        Schema::create('Uzdevumi', function (Blueprint $table) {
            $table->id('ID_uzdevums');
            $table->foreignId('ID_projekts')->references('ID_projekts')->on('ProjNosaukums');
            $table->string('uzdTips');
            $table->timestamp('veidDat');
            $table->timestamp('termins')->nullable()->default(null);
            $table->string('uzdNos');
            $table->string('uzdStat');
            $table->string('uzdIp');
            $table->string('uzdReg');
        });

        Schema::create('UzdApraksts', function (Blueprint $table) {
            $table->id('ID_uzdapraksts');
            $table->foreignId('ID_uzdevums')->references('ID_uzdevums')->on('Uzdevumi');
            $table->text('aprTeksts')->nullable();
            $table->timestamp('regDatApr');
            $table->timestamp('red_datApr')->nullable();
            $table->timestamp('dzesDatApr')->nullable();
        });

        Schema::create('UzdPielikumi', function (Blueprint $table) {
            $table->id('ID_pielikums');
            $table->foreignId('ID_uzdevums')->references('ID_uzdevums')->on('Uzdevumi');
            $table->foreignId('ID_aut')->references('ID_aut')->on('Autentifikacija');
            $table->timestamp('pielPievDat');
            $table->timestamp('pielRedDat')->nullable();
            $table->timestamp('pielDzesDat')->nullable();
        });

        Schema::create('UzdKomentari', function (Blueprint $table) {
            $table->id('ID_komentars');
            $table->foreignId('ID_lietotajs')->references('ID_aut')->on('Autentifikacija');
            $table->foreignId('ID_uzdevums')->references('ID_uzdevums')->on('Uzdevumi');
            $table->text('komTeksts');
            $table->timestamp('regDatKom');
            $table->timestamp('red_datKom')->nullable();
            $table->timestamp('dzesDatKom')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('UzdKomentari');
        Schema::dropIfExists('UzdPielikumi');
        Schema::dropIfExists('UzdApraksts');
        Schema::dropIfExists('Uzdevumi');
    }
};
