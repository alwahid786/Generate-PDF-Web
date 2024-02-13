<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLigteningFieldsInLibraryFixtures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('library_fixtures', function (Blueprint $table) {
            $table->string('manufacturer')->nullable();
            $table->string('description')->nullable();
            $table->string('lamp')->nullable();
            $table->string('voltage')->nullable();
            $table->string('dimming')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('library_fixtures', function (Blueprint $table) {
            //
        });
    }
}
