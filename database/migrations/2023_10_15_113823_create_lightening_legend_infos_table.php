<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLighteningLegendInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lightening_legend_infos', function (Blueprint $table) {
            $table->id();
            $table->string('legend_id');
            $table->string('manufacturer')->nullable();
            $table->string('description')->nullable();
            $table->string('part_number')->nullable();
            $table->string('lamp')->nullable();
            $table->string('voltage')->nullable();
            $table->string('dimming')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lightening_legend_infos');
    }
}
