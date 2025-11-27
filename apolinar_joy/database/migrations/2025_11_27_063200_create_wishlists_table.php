<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
      Schema::create('wishlists', function (Blueprint $table) {
    $table->id(); // wishlist id
    $table->unsignedBigInteger('user_id'); // users.id usually bigIncrements
    $table->unsignedBigInteger('product_id'); // MUST match products.product_id
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
});
    }

    public function down()
    {
        Schema::dropIfExists('wishlists');
    }
};
