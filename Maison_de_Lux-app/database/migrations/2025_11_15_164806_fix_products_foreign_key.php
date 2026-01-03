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
        // Drop the foreign key only if it exists
        if (Schema::hasColumn('products', 'admin_id')) {
            try {
                $table->dropForeign(['admin_id']);
            } catch (\Exception $e) {
                // Ignore if foreign key does not exist
            }

            // After dropping, rename column
            $table->renameColumn('admin_id', 'user_id');
        }
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
            $table->dropForeign('products_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('admins');
        });
    }
};
