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
    Schema::table('customer', function (Blueprint $table) {
        if (!Schema::hasColumn('customer', 'email_verified_at')) {
            $table->timestamp('email_verified_at')->nullable()->after('email');
        }
    });
}

public function down()
{
    Schema::table('customer', function (Blueprint $table) {
        $table->dropColumn('email_verified_at');
    });
}


};
