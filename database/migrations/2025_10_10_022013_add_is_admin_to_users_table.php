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
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'is_admin')) {
            $table->boolean('is_admin')->default(0);
        }

        if (!Schema::hasColumn('users', 'avatar')) {
            $table->string('avatar')->nullable()->after('email'); // optional profile image
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_admin', 'avatar']);
        });
    }
};
