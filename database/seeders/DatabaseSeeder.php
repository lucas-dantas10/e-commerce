<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::factory()->count(10)->create();
        // $this->call([
        //     AdminUserSeeder::class,
        //     CountrySeeder::class,
        //     CustomerSeeder::class
        // ]);
    }
}
