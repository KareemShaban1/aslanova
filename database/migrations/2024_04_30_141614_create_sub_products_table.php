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
        Schema::create('sub_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id');//عامود الربط

            $table->string('Width');
            $table->string('Height');
            $table->string('Thickness');
            $table->decimal('capital', 10, 2);
            $table->integer('quantity');
            $table->string('type');
            $table->string('file')->nullable();
            $table->text('desc');
            $table->decimal('price', 10, 2);
            $table->string('name');
            $table->string('color');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

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
        Schema::dropIfExists('sub_products');
    }
};
