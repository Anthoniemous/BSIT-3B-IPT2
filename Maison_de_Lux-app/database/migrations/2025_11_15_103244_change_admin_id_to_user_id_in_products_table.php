<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the foreign key first
            $table->dropForeign(['admin_id']);
            
            // Rename the column
            $table->renameColumn('admin_id', 'user_id');

            // Add new foreign key to users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the foreign key to users first
            $table->dropForeign(['user_id']);

            // Rename column back
            $table->renameColumn('user_id', 'admin_id');

            // Add foreign key back to admins table
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }
};
