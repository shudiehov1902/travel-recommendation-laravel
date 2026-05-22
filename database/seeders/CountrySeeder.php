<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['name' => 'Spain', 'iso_code' => 'es', 'capital' => 'Madrid', 'currency_code' => 'EUR', 'currency_name' => 'Euro'],
            ['name' => 'Italy', 'iso_code' => 'it', 'capital' => 'Rome', 'currency_code' => 'EUR', 'currency_name' => 'Euro'],
            ['name' => 'Greece', 'iso_code' => 'gr', 'capital' => 'Athens', 'currency_code' => 'EUR', 'currency_name' => 'Euro'],
            ['name' => 'Croatia', 'iso_code' => 'hr', 'capital' => 'Zagreb', 'currency_code' => 'EUR', 'currency_name' => 'Euro'],
            ['name' => 'Austria', 'iso_code' => 'at', 'capital' => 'Vienna', 'currency_code' => 'EUR', 'currency_name' => 'Euro'],
            ['name' => 'Czech Republic', 'iso_code' => 'cz', 'capital' => 'Prague', 'currency_code' => 'CZK', 'currency_name' => 'Czech koruna'],
            ['name' => 'Hungary', 'iso_code' => 'hu', 'capital' => 'Budapest', 'currency_code' => 'HUF', 'currency_name' => 'Hungarian forint'],
            ['name' => 'France', 'iso_code' => 'fr', 'capital' => 'Paris', 'currency_code' => 'EUR', 'currency_name' => 'Euro'],
            ['name' => 'Netherlands', 'iso_code' => 'nl', 'capital' => 'Amsterdam', 'currency_code' => 'EUR', 'currency_name' => 'Euro'],
            ['name' => 'Switzerland', 'iso_code' => 'ch', 'capital' => 'Bern', 'currency_code' => 'CHF', 'currency_name' => 'Swiss franc'],
            ['name' => 'Portugal', 'iso_code' => 'pt', 'capital' => 'Lisbon', 'currency_code' => 'EUR', 'currency_name' => 'Euro'],
            ['name' => 'Turkey', 'iso_code' => 'tr', 'capital' => 'Ankara', 'currency_code' => 'TRY', 'currency_name' => 'Turkish lira'],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['iso_code' => $country['iso_code']],
                $country
            );
        }
    }
}
