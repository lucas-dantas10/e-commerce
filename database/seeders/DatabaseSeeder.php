<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\AddressType;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class, 
            CountrySeeder::class,
            CustomerAddressSeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class
        ]);
    }
}
