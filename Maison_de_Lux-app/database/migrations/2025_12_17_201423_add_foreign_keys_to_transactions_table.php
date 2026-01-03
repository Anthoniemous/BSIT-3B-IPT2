<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Add columns if not exist
            if (!Schema::hasColumn('transactions', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
            }
            if (!Schema::hasColumn('transactions', 'order_id')) {
                $table->unsignedBigInteger('order_id')->after('user_id');
            }
            if (!Schema::hasColumn('transactions', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->after('order_id');
            }
            if (!Schema::hasColumn('transactions', 'transaction_status')) {
                $table->enum('transaction_status', ['pending', 'completed', 'failed', 'refunded'])
                    ->default('pending')
                    ->after('total_amount');
            }
            if (!Schema::hasColumn('transactions', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('transaction_status');
            }
            if (!Schema::hasColumn('transactions', 'transaction_reference')) {
                $table->string('transaction_reference')->nullable()->after('payment_method');
            }

            // Add foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['order_id']);
        });
    }
};