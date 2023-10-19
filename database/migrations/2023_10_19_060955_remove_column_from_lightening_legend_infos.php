<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnFromLighteningLegendInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lightening_legend_infos', function (Blueprint $table) {
            $table->dropColumn('legend_id');
            $table->string('pakage_info_id');
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
            $table->string('legend_id');
            $table->dropColumn('pakage_info_id');
        });
    }
}
