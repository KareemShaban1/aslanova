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
        Schema::create('textures_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_payment_id')->nullable()->constrained('email_payments')->onDelete('cascade');
            $table->string('name'); // اسم الجزء
            $table->decimal('price', 10, 2); // سعر الجزء
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
        Schema::dropIfExists('textures_payments');
    }
};
