<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('carts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');

    // Correct foreign key to match your products table
    $table->unsignedBigInteger('product_id');
    $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');

    $table->integer('quantity')->default(1);
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
