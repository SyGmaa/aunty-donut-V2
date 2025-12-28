<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Variants (Flavors)
        $flavors = [
            ['name' => 'Choco Crunchy', 'slug' => 'choco-crunchy', 'stock' => 50],
            ['name' => 'Strawberry Supreme', 'slug' => 'strawberry-supreme', 'stock' => 50],
            ['name' => 'Matcha Latte', 'slug' => 'matcha-latte', 'stock' => 20], // Low stock test
            ['name' => 'Classic Glazed', 'slug' => 'classic-glazed', 'stock' => 100],
            ['name' => 'Tiramisu', 'slug' => 'tiramisu', 'stock' => 0], // Out of stock test
            ['name' => 'Blueberry Cheese', 'slug' => 'blueberry-cheese', 'stock' => 40],
        ];

        $variantModels = [];
        foreach ($flavors as $f) {
            $variantModels[] = Variant::create($f);
        }

        // 2. Create Products

        // Single Donut (Not a bundle)
        Product::create([
            'name' => 'Single Classic Donut',
            'slug' => 'single-classic',
            'description' => 'One piece of our signature fluffy donut.',
            'price' => 12000,
            'is_bundle' => false,
        ]);

        // Bundle: Box of 6
        $box6 = Product::create([
            'name' => 'Happiness Box (6 Pcs)',
            'slug' => 'box-of-6',
            'description' => 'Perfect for sharing! Pick any 6 of your favorite flavors.',
            'price' => 65000, // Discounted from 12k * 6
            'is_bundle' => true,
            'bundle_size' => 6,
        ]);

        // Attach flavors to box 6 (All flavors available)
        $box6->variants()->attach(collect($variantModels)->pluck('id'));

        // Bundle: Box of 12
        $box12 = Product::create([
            'name' => 'Party Pack (12 Pcs)',
            'slug' => 'box-of-12',
            'description' => 'The ultimate party starter. Choose 12 donuts.',
            'price' => 125000,
            'is_bundle' => true,
            'bundle_size' => 12,
        ]);

        // Attach flavors to box 12 (Maybe exclude Tiramisu just to test logic? Nah, let's include all)
        $box12->variants()->attach(collect($variantModels)->pluck('id'));

        // Create Admin User for Filament
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@auntydonut.com',
            'password' => bcrypt('password'),
        ]);

        $this->command->info('Aunty Donut seeded! Login: admin@auntydonut.com / password');
    }
}
