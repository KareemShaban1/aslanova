<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products_3d', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file');//صورة المنتج
            $table->text('desc');
            $table->decimal('price', 8, 2);
            $table->text('model_id');
            $table->unsignedBigInteger('category3d_id');//عامود الربط
            $table->foreign('category3d_id')->references('id')->on('category3ds')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_3d');
    }
};
