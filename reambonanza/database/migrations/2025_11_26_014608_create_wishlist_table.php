<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlist', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');

            $table->timestamps();

            // FK for users table
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            // FK for products table
            $table->foreign('product_id')
                  ->references('product_id')->on('products')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlist');
    }
};
