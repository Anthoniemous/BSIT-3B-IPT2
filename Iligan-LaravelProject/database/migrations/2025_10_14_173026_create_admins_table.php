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
        Schema::create('admins', function (Blueprint $table) {
            $table->id('admin_id');
            $table->string('lname');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable(); // nullable for Google login
            $table->string('phone')->nullable();
            $table->string('google_id')->nullable()->unique(); // Google login
            $table->string('role')->default('admin');
            $table->string('status')->default('active');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
