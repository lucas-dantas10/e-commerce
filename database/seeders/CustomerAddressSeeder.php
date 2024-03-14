<?php

namespace Database\Seeders;

use App\Enums\AddressType;
use App\Models\CustomerAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomerAddress::factory()->create();
        CustomerAddress::factory()->create(['type' => AddressType::BillingAddresses->value]);
    }
}
