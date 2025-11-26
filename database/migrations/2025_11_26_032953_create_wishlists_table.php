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
    Schema::create('wishlists', function (Blueprint $table) {
        $table->id();

        // users.id → BIGINT
        $table->unsignedBigInteger('user_id');

        // products.product_id → BIGINT UNSIGNED
        $table->unsignedBigInteger('product_id');

        $table->timestamps();

        $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

        $table->foreign('product_id')
            ->references('product_id')->on('products')
            ->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wishlists');
    }
};
