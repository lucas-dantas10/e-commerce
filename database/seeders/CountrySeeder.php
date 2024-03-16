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
            "AL" => "Alabama",
            "AK" => "Alaska",
            "AS" => "American Samoa",
            "AZ" => "Arizona",
            "AR" => "Arkansas",
            "CA" => "California",
            "CO" => "Colorado",
            "CT" => "Connecticut",
            "DE" => "Delaware",
            "DC" => "District Of Columbia",
            "FM" => "Federated States Of Micronesia",
            "FL" => "Florida",
            "GA" => "Georgia",
            "GU" => "Guam",
            "HI" => "Hawaii",
            "ID" => "Idaho",
            "IL" => "Illinois",
            "IN" => "Indiana",
            "IA" => "Iowa",
            "KS" => "Kansas",
            "KY" => "Kentucky",
            "LA" => "Louisiana",
            "ME" => "Maine",
            "MH" => "Marshall Islands",
            "MD" => "Maryland",
            "MA" => "Massachusetts",
            "MI" => "Michigan",
            "MN" => "Minnesota",
            "MS" => "Mississippi",
            "MO" => "Missouri",
            "MT" => "Montana",
            "NE" => "Nebraska",
            "NV" => "Nevada",
            "NH" => "New Hampshire",
            "NJ" => "New Jersey",
            "NM" => "New Mexico",
            "NY" => "New York",
            "NC" => "North Carolina",
            "ND" => "North Dakota",
            "MP" => "Northern Mariana Islands",
            "OH" => "Ohio",
            "OK" => "Oklahoma",
            "OR" => "Oregon",
            "PW" => "Palau",
            "PA" => "Pennsylvania",
            "PR" => "Puerto Rico",
            "RI" => "Rhode Island",
            "SC" => "South Carolina",
            "SD" => "South Dakota",
            "TN" => "Tennessee",
            "TX" => "Texas",
            "UT" => "Utah",
            "VT" => "Vermont",
            "VI" => "Virgin Islands",
            "VA" => "Virginia",
            "WA" => "Washington",
            "WV" => "West Virginia",
            "WI" => "Wisconsin",
            "WY" => "Wyoming"
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

        $germanyStates = [
            "DE-BW" => "Baden-Württemberg",
            "DE-BY" => "Bayern",
            "DE-BE" => "Berlin",
            "DE-BB" => "Brandenburg",
            "DE-HB" => "Bremen",
            "DE-HH" => "Hamburg",
            "DE-HE" => "Hessen",
            "DE-MV" => "Mecklenburg-Vorpommern",
            "DE-NI" => "Niedersachsen",
            "DE-NW" => "Nordrhein-Westfalen",
            "DE-RP" => "Rheinland-Pfalz",
            "DE-SL" => "Saarland",
            "DE-SN" => "Sachsen",
            "DE-ST" => "Sachsen-Anhalt",
            "DE-SH" => "Schleswig-Holstein",
            "DE-TH" => "Thüringen"
        ];

        $brazilStates = [
            "AC" => "Acre",
            "AL" => "Alagoas",
            "AM" => "Amazonas",
            "AP" => "Amapá",
            "BA" => "Bahia",
            "CE" => "Ceará",
            "DF" => "Distrito Federal",
            "ES" => "Espírito Santo",
            "GO" => "Goiás",
            "MA" => "Maranhão",
            "MG" => "Minas Gerais",
            "MS" => "Mato Grosso do Sul",
            "MT" => "Mato Grosso",
            "PA" => "Pará",
            "PB" => "Paraíba",
            "PE" => "Pernambuco",
            "PI" => "Piauí",
            "PR" => "Paraná",
            "RJ" => "Rio de Janeiro",
            "RN" => "Rio Grande do Norte",
            "RO" => "Rondônia",
            "RR" => "Roraima",
            "RS" => "Rio Grande do Sul",
            "SC" => "Santa Catarina",
            "SE" => "Sergipe",
            "SP" => "São Paulo",
            "TO" => "Tocantins"
        ];

        $countries = [
            ['code' => 'geo', 'name' => 'Brasil', 'states' => json_encode($brazilStates)],
            ['code' => 'ind', 'name' => 'India', 'states' => json_encode($indiaStates)],
            ['code' => 'usa', 'name' => 'Estados Unidos', 'states' => json_encode($usaStates)],
            ['code' => 'ger', 'name' => 'Alemanha', 'states' => json_encode($germanyStates)],
        ];
        Country::insert($countries);
    }
}
