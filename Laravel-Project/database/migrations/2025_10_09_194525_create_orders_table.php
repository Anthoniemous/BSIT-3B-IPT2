<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id'); // ✅ matches what order_items will reference
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('address');
            $table->string('contact_number');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('Pending');
            $table->timestamps();

            // ✅ Foreign key for user
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
