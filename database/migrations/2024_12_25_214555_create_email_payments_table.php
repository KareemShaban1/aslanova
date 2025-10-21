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
        Schema::create('email_payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('sub_products')->onDelete('cascade');
            $table->string('product_name');
            $table->string('quantity');
            $table->decimal('amount', 10, 2);
            $table->string('currency');
            $table->string('payer_name');
            $table->string('payer_email');
            $table->string('payment_status');
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
            $table->string('message')->nullable();
            $table->string('payment_method')->nullable();
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
        Schema::dropIfExists('email_payments');
    }
};
