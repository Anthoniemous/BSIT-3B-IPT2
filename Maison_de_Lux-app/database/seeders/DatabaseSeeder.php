<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create regular users
        \App\Models\User::factory(5)->create([
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Create products
        \App\Models\Product::factory(20)->create();
    }
}
