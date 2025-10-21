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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // الربط بجدول المستخدم
            $table->string('country');
            $table->string('street');
            $table->string('address');
            $table->string('zip_code');
            $table->string('location');
            $table->string('phone');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('locations');
    }
    

};
