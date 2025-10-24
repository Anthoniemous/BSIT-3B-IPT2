<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'product_name' => 'Jordan Shoes',
            'description' => 'Classic Air Jordan basketball shoes.',
            'price' => 250.00,
            'image' => 'products/jordan.png'
        ]);

        Product::create([
            'product_name' => 'Lakers Jersey',
            'description' => 'Official Lakers Jersey.',
            'price' => 120.00,
            'image' => 'products/jersey.png'
        ]);

        Product::create([
            'product_name' => 'Brooklyn Cap',
            'description' => 'Stylish Brooklyn Nets Cap.',
            'price' => 45.00,
            'image' => 'products/cap.png'
        ]);
    }
}
