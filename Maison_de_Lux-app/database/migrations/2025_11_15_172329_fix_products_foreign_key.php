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
        Schema::table('products', function (Blueprint $table) {
            // Drop the old foreign key constraint pointing to admins table
            $table->dropForeign(['user_id']);
            // Add new foreign key constraint pointing to users table
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the foreign key constraint pointing to users table
            $table->dropForeign(['user_id']);
            // Add back the foreign key constraint pointing to admins table
            $table->foreign('user_id')->references('id')->on('admins');
        });
    }
};
