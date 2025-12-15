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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // 1. Foreign Key para i-link sa Order
            // Importante ni aron mahibal-an kung kinsa nga order kini nga item
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade'); // Kung ma-delete ang Order, ma-delete sad ang items

            // 2. Foreign Key para i-link sa Product
            // Importante ni aron mahibal-an kung unsa nga product ang gi-order
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('restrict'); // Ayaw i-delete ang product kung naa pay order

            // 3. Item Details
            $table->integer('quantity');
            
            // Ang presyo sa produkto TUNGOD sa pag-order (Basin mausab ang presyo sa umaabot)
            $table->decimal('price', 10, 2); 
            
            // Total price sa item line (quantity * price)
            $table->decimal('total', 10, 2); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};