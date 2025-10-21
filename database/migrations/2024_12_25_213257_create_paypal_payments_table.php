<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('product_name');
            $table->string('quantity');
            $table->string('amount');
            $table->string('currency');
            $table->string('payer_name');
            $table->string('payer_email');
            // ---------- location data ----------
            $table->string('country')->nullable();
            $table->string('street')->nullable();
            $table->string('address')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            // ---------- vat data ----------
            $table->decimal('vat', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->string('payment_status');
            $table->string('payment_method');
            $table->timestamps();

            // مفتاح خارجي للمستخدم
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paypal_payments');
    }
};
