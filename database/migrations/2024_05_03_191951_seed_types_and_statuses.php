<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        foreach (['To Do', 'In Progress', 'Done', 'Won\'t Do', 'Closed'] as $statuss) {
            if (!DB::table('UzdStatusi')->where('uzdStatuss', $statuss)->exists()) {
                DB::table('UzdStatusi')->insert(['uzdStatuss' => $statuss]);
            }
        }

        foreach (['Task', 'Bug', 'Feature'] as $tipi) {
            if (!DB::table('UzdTipi')->where('uzdTips', $tipi)->exists()) {
                DB::table('UzdTipi')->insert(['uzdTips' => $tipi]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('UzdStatusi')->whereIn('uzdStatuss', ['To Do', 'In Progress', 'Done', 'Won\'t Do', 'Closed'])->delete();
        DB::table('UzdTipi')->whereIn('uzdTips', ['Task', 'Bug', 'Feature'])->delete();
    }
};
