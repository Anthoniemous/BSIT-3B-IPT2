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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // 1. Order Ownership and Summary
            // Foreign Key para i-link ang order sa user
            $table->foreignId('user_id')
                  ->constrained('users') // Assumes your user table is named 'users'
                  ->onDelete('cascade'); // Delete orders if user is deleted

            // Final nga presyo sa order
            $table->decimal('total_amount', 10, 2); 
            
            // Status sa Order: e.g., 'pending', 'processing', 'delivered'
            $table->string('status')->default('pending');

            // 2. Shipping and Contact Details
            // Kining data gigamit aron ma-save ang shipping address at the time of order
            $table->string('full_name')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            
            // 3. Payment Details
            $table->string('payment_method'); // e.g., COD
            $table->string('tracking_number')->nullable(); // Optional tracking number

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};