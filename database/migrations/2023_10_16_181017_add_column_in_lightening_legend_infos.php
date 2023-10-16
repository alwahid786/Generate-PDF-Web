<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInLighteningLegendInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lightening_legend_infos', function (Blueprint $table) {
            $table->string('fixture_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lightening_legend_infos', function (Blueprint $table) {
            $table->dropColumn('fixture_id');
        });
    }
}
