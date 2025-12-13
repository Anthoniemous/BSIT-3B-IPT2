<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'status')) {
                $table->string('status')->default('active');
            }
            if (!Schema::hasColumn('products', 'total_sold')) {
                $table->integer('total_sold')->default(0);
            }
            if (!Schema::hasColumn('products', 'quantity')) {
                $table->integer('quantity')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('products', 'total_sold')) {
                $table->dropColumn('total_sold');
            }
            if (Schema::hasColumn('products', 'quantity')) {
                $table->dropColumn('quantity');
            }
        });
    }
};
