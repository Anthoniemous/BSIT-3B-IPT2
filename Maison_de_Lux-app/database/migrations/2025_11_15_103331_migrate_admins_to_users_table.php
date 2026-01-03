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
        // Migrate existing admins to users table with role 'admin'
        $admins = DB::table('admins')->get();
        foreach ($admins as $admin) {
            DB::table('users')->insert([
                'name' => $admin->name,
                'email' => $admin->email,
                'password' => $admin->password,
                'role' => 'admin',
                'image' => $admin->image ?? null,
                'google_id' => $admin->google_id ?? null,
                'email_verified_at' => $admin->email_verified_at,
                'created_at' => $admin->created_at,
                'updated_at' => $admin->updated_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove admins from users table
        DB::table('users')->where('role', 'admin')->delete();
    }
};
