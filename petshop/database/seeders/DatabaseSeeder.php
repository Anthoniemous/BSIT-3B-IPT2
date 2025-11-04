<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Species;
use App\Models\Traits;
use App\Models\Supplier;
use App\Models\Pet;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'firstname' => 'Admin',
            'lastname' => 'User',
            'email' => 'admin@pawparadise.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'contact' => '+63 123 456 7890',
            'address' => '123 Admin Street, Davao City',
        ]);

        // Create Customer Users
        User::create([
            'firstname' => 'Juan',
            'lastname' => 'Dela Cruz',
            'email' => 'juan@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'contact' => '+63 987 654 3210',
            'address' => '456 Customer Avenue, Davao City',
        ]);

        User::create([
            'firstname' => 'Maria',
            'lastname' => 'Santos',
            'email' => 'maria@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'contact' => '+63 912 345 6789',
            'address' => '789 User Boulevard, Davao City',
        ]);

        // Create Species
        $species = [
            ['name' => 'Dog', 'description' => 'Loyal and friendly companions'],
            ['name' => 'Cat', 'description' => 'Independent and affectionate pets'],
            ['name' => 'Bird', 'description' => 'Colorful and vocal companions'],
            ['name' => 'Rabbit', 'description' => 'Gentle and social animals'],
            ['name' => 'Hamster', 'description' => 'Small and playful pets'],
            ['name' => 'Guinea Pig', 'description' => 'Friendly and easy to care for'],
            ['name' => 'Fish', 'description' => 'Beautiful aquatic pets'],
            ['name' => 'Turtle', 'description' => 'Long-lived reptile companions'],
        ];

        foreach ($species as $specie) {
            Species::create($specie);
        }

        // Create Traits
        $traits = [
            ['description' => 'Friendly and playful'],
            ['description' => 'Calm and gentle'],
            ['description' => 'Energetic and active'],
            ['description' => 'Intelligent and trainable'],
            ['description' => 'Affectionate and loving'],
            ['description' => 'Independent and low-maintenance'],
            ['description' => 'Social and outgoing'],
            ['description' => 'Quiet and peaceful'],
        ];

        foreach ($traits as $trait) {
            Traits::create($trait);
        }

        // Create Suppliers
        $suppliers = [
            [
                'firstname' => 'Pedro',
                'lastname' => 'Reyes',
                'middlename' => 'Garcia',
                'contact' => '+63 922 111 2222',
                'address' => '123 Supplier Street, Manila',
            ],
            [
                'firstname' => 'Ana',
                'lastname' => 'Lopez',
                'middlename' => 'Mendoza',
                'contact' => '+63 933 222 3333',
                'address' => '456 Vendor Avenue, Cebu',
            ],
            [
                'firstname' => 'Carlos',
                'lastname' => 'Diaz',
                'middlename' => null,
                'contact' => '+63 944 333 4444',
                'address' => '789 Distributor Road, Davao',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // Create Pets
        $pets = [
            // Dogs
            [
                'name' => 'Golden Retriever Puppy',
                'breed' => 'Golden Retriever',
                'price' => 25000.00,
                'quantity' => 5,
                'arrival_date' => now()->subDays(10),
                'trait_id' => 1,
                'species_id' => 1,
                'supplier_id' => 1,
                'description' => 'Beautiful golden retriever puppies, friendly and family-oriented.',
            ],
            [
                'name' => 'Labrador Puppy',
                'breed' => 'Labrador',
                'price' => 22000.00,
                'quantity' => 3,
                'arrival_date' => now()->subDays(5),
                'trait_id' => 4,
                'species_id' => 1,
                'supplier_id' => 1,
                'description' => 'Intelligent and trainable Labrador puppies.',
            ],
            [
                'name' => 'Shih Tzu',
                'breed' => 'Shih Tzu',
                'price' => 18000.00,
                'quantity' => 4,
                'arrival_date' => now()->subDays(15),
                'trait_id' => 5,
                'species_id' => 1,
                'supplier_id' => 2,
                'description' => 'Adorable Shih Tzu puppies, perfect lap dogs.',
            ],
            [
                'name' => 'Beagle',
                'breed' => 'Beagle',
                'price' => 20000.00,
                'quantity' => 2,
                'arrival_date' => now()->subDays(8),
                'trait_id' => 3,
                'species_id' => 1,
                'supplier_id' => 1,
                'description' => 'Energetic and curious Beagle puppies.',
            ],
            // Cats
            [
                'name' => 'Persian Cat',
                'breed' => 'Persian',
                'price' => 15000.00,
                'quantity' => 6,
                'arrival_date' => now()->subDays(12),
                'trait_id' => 2,
                'species_id' => 2,
                'supplier_id' => 2,
                'description' => 'Beautiful Persian cats with long, luxurious coats.',
            ],
            [
                'name' => 'Siamese Kitten',
                'breed' => 'Siamese',
                'price' => 12000.00,
                'quantity' => 5,
                'arrival_date' => now()->subDays(7),
                'trait_id' => 7,
                'species_id' => 2,
                'supplier_id' => 2,
                'description' => 'Vocal and social Siamese kittens.',
            ],
            [
                'name' => 'Scottish Fold',
                'breed' => 'Scottish Fold',
                'price' => 18000.00,
                'quantity' => 3,
                'arrival_date' => now()->subDays(20),
                'trait_id' => 5,
                'species_id' => 2,
                'supplier_id' => 3,
                'description' => 'Unique folded ears and sweet temperament.',
            ],
            // Birds
            [
                'name' => 'Lovebird Pair',
                'breed' => 'Lovebird',
                'price' => 3500.00,
                'quantity' => 10,
                'arrival_date' => now()->subDays(5),
                'trait_id' => 7,
                'species_id' => 3,
                'supplier_id' => 3,
                'description' => 'Colorful and affectionate lovebird pairs.',
            ],
            [
                'name' => 'Cockatiel',
                'breed' => 'Cockatiel',
                'price' => 4500.00,
                'quantity' => 8,
                'arrival_date' => now()->subDays(10),
                'trait_id' => 1,
                'species_id' => 3,
                'supplier_id' => 3,
                'description' => 'Friendly cockatiels, great for beginners.',
            ],
            // Rabbits
            [
                'name' => 'Holland Lop Rabbit',
                'breed' => 'Holland Lop',
                'price' => 2500.00,
                'quantity' => 7,
                'arrival_date' => now()->subDays(14),
                'trait_id' => 2,
                'species_id' => 4,
                'supplier_id' => 2,
                'description' => 'Adorable rabbits with floppy ears.',
            ],
            [
                'name' => 'Dwarf Rabbit',
                'breed' => 'Netherland Dwarf',
                'price' => 2000.00,
                'quantity' => 6,
                'arrival_date' => now()->subDays(9),
                'trait_id' => 6,
                'species_id' => 4,
                'supplier_id' => 2,
                'description' => 'Small and easy to care for dwarf rabbits.',
            ],
            // Hamsters
            [
                'name' => 'Syrian Hamster',
                'breed' => 'Syrian',
                'price' => 500.00,
                'quantity' => 15,
                'arrival_date' => now()->subDays(3),
                'trait_id' => 1,
                'species_id' => 5,
                'supplier_id' => 3,
                'description' => 'Playful Syrian hamsters, perfect starter pets.',
            ],
            // Guinea Pigs
            [
                'name' => 'Guinea Pig',
                'breed' => 'American',
                'price' => 1200.00,
                'quantity' => 8,
                'arrival_date' => now()->subDays(6),
                'trait_id' => 5,
                'species_id' => 6,
                'supplier_id' => 2,
                'description' => 'Friendly guinea pigs, great with children.',
            ],
        ];

        foreach ($pets as $pet) {
            Pet::create($pet);
        }

        $this->command->info('Database seeded successfully!');
    }
}