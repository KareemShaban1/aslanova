<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryMain3dTable extends Migration
{

        /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('category_main_3d', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('desc')->nullable();
            $table->string('file'); // صورة المنتج
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
        Schema::dropIfExists('category_main_3d');
    }
}
