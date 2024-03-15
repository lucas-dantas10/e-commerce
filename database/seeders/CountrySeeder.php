<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usaStates = [
            "AL" => 'Alabama',
            "AK" => 'Alaska',
            "AZ" => 'Arizona',
            "AR" => 'Arkansas',
            "CA" => 'California',
        ];

        $indiaStates = [
            "AN" => "Andaman and Nicobar Islands",
            "AP" => "Andhra Pradesh",
            "AR" => "Arunachal Pradesh",
            "AS" => "Assam",
            "BR" => "Bihar",
            "CG" => "Chandigarh",
            "CH" => "Chhattisgarh",
            "DN" => "Dadra and Nagar Haveli",
            "DD" => "Daman and Diu",
            "DL" => "Delhi",
            "GA" => "Goa",
        ];

        $countries = [
            ['code' => 'geo', 'name' => 'Georgia', 'states' => null],
            ['code' => 'ind', 'name' => 'India', 'states' => json_encode($indiaStates)],
            ['code' => 'usa', 'name' => 'United States of America', 'states' => json_encode($usaStates)],
            ['code' => 'ger', 'name' => 'Germany', 'states' => null],
        ];
        Country::insert($countries);
    }
}
