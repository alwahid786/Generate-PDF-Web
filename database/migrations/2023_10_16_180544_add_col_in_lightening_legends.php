<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColInLighteningLegends extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lightening_legends', function (Blueprint $table) {
            $table->dropColumn('fixture_id');
            $table->string('package_info_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lightening_legends', function (Blueprint $table) {
            $table->string('fixture_id');
            $table->dropColumn('package_info_id');
        });
    }
}
