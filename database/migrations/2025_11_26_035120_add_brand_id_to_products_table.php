<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Siguraduhon nga wala pa ang column
            if (!Schema::hasColumn('products', 'brand_id')) {
                $table->unsignedBigInteger('brand_id')->nullable()->after('category_id');
                $table->foreign('brand_id')
                      ->references('brand_id') // <-- primary key sa brands
                      ->on('brands')
                      ->nullOnDelete();       // set null kung i-delete ang brand
            }
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
        });
    }
};
