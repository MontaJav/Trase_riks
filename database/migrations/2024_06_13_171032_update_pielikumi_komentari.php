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
        if (!Schema::hasColumn('UzdPielikumi', 'pielNos')) {
            Schema::table('UzdPielikumi', function (Blueprint $table) {
                $table->string('pielNos');
            });
        }

        if (!Schema::hasColumn('UzdPielikumi', 'ID_aut')) {
            Schema::table('UzdPielikumi', function (Blueprint $table) {
                $table->foreignId('ID_aut')->references('ID_aut')->on('Autentifikacija');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
