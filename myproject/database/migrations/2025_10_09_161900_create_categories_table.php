<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Optional default categories
        DB::table('categories')->insert([
            ['name' => 'Coffee'],
            ['name' => 'Espresso'],
            ['name' => 'Latte'],
            ['name' => 'Cappuccino'],
            ['name' => 'Tea'],
            ['name' => 'Pastries'],
            ['name' => 'Snacks']
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
