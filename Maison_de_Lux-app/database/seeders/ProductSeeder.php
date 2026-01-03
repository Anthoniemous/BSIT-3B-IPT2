<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Sample Product',
            'description' => 'This is a sample product',
            'price' => 99.99,
            'quantity' => 100,
            'sku' => 'PROD-001',
        ]);
    }
}