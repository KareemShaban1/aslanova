<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertisements', function (Blueprint $table) {
            //
	  DB::statement("ALTER TABLE advertisements MODIFY COLUMN type ENUM('banner', 'special_offer', 'advertisement') DEFAULT 'banner'");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advertisements', function (Blueprint $table) {
            //
	  DB::statement("ALTER TABLE advertisements MODIFY COLUMN type ENUM('banner', 'special_offer') DEFAULT 'banner'");

        });
    }
};