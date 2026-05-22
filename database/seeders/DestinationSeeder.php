<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Destination;
use App\Models\DestinationType;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    private const IMAGE_KEYWORDS = [
        'Barcelona' => 'barcelona,spain,travel',
        'Valencia' => 'valencia,spain,travel',
        'Rome' => 'rome,italy,travel',
        'Florence' => 'florence,italy,travel',
        'Athens' => 'athens,greece,travel',
        'Santorini' => 'santorini,greece,travel',
        'Split' => 'split,croatia,travel',
        'Dubrovnik' => 'dubrovnik,croatia,travel',
        'Vienna' => 'vienna,austria,travel',
        'Prague' => 'prague,czech,travel',
        'Budapest' => 'budapest,hungary,travel',
        'Paris' => 'paris,france,travel',
        'Amsterdam' => 'amsterdam,netherlands,travel',
        'Zurich' => 'zurich,switzerland,travel',
        'Innsbruck' => 'innsbruck,austria,mountains',
        'Zermatt' => 'zermatt,switzerland,mountains',
        'Madeira' => 'madeira,portugal,travel',
        'Lisbon' => 'lisbon,portugal,travel',
        'Mallorca' => 'mallorca,spain,beach',
        'Istanbul' => 'istanbul,turkey,travel',
    ];

    public function run(): void
    {
        $countries = Country::all()->keyBy('iso_code');
        $types = DestinationType::all()->keyBy('name');

        $destinations = [
            [
                'country_iso' => 'es',
                'name' => 'Barcelona',
                'description' => 'Stredomorské mesto s plážami, architektúrou Gaudího a živou mestskou atmosférou.',
                'latitude' => 41.3874,
                'longitude' => 2.1686,
                'nearest_weather_city' => 'Barcelona',
                'flight_hours_from_vienna' => 2.30,
                'types' => ['more a pláž', 'historické mestá', 'mestský výlet'],
            ],
            [
                'country_iso' => 'es',
                'name' => 'Valencia',
                'description' => 'Slnečné pobrežné mesto s plážami, modernou architektúrou a príjemným tempom.',
                'latitude' => 39.4699,
                'longitude' => -0.3763,
                'nearest_weather_city' => 'Valencia',
                'flight_hours_from_vienna' => 2.60,
                'types' => ['more a pláž', 'mestský výlet'],
            ],
            [
                'country_iso' => 'it',
                'name' => 'Rome',
                'description' => 'Historická metropola s antickými pamiatkami, múzeami a talianskou gastronómiou.',
                'latitude' => 41.9028,
                'longitude' => 12.4964,
                'nearest_weather_city' => 'Rome',
                'flight_hours_from_vienna' => 1.60,
                'types' => ['historické mestá', 'mestský výlet'],
            ],
            [
                'country_iso' => 'it',
                'name' => 'Florence',
                'description' => 'Renesančné mesto vhodné pre umenie, históriu a pokojnejší kultúrny pobyt.',
                'latitude' => 43.7696,
                'longitude' => 11.2558,
                'nearest_weather_city' => 'Florence',
                'flight_hours_from_vienna' => 1.50,
                'types' => ['historické mestá', 'mestský výlet'],
            ],
            [
                'country_iso' => 'gr',
                'name' => 'Athens',
                'description' => 'Staroveké pamiatky, mestský život a dobrý východiskový bod na grécke pobrežie.',
                'latitude' => 37.9838,
                'longitude' => 23.7275,
                'nearest_weather_city' => 'Athens',
                'flight_hours_from_vienna' => 2.20,
                'types' => ['historické mestá', 'mestský výlet'],
            ],
            [
                'country_iso' => 'gr',
                'name' => 'Santorini',
                'description' => 'Kykladský ostrov s bielymi dedinami, výhľadmi na kalderu a letnou dovolenkovou atmosférou.',
                'latitude' => 36.3932,
                'longitude' => 25.4615,
                'nearest_weather_city' => 'Thira',
                'flight_hours_from_vienna' => 2.40,
                'types' => ['more a pláž', 'aktivity a dobrodružstvo'],
            ],
            [
                'country_iso' => 'hr',
                'name' => 'Split',
                'description' => 'Dalmátske mesto pri mori s Diokleciánovým palácom a dostupnými ostrovmi.',
                'latitude' => 43.5081,
                'longitude' => 16.4402,
                'nearest_weather_city' => 'Split',
                'flight_hours_from_vienna' => 1.20,
                'types' => ['more a pláž', 'historické mestá', 'mestský výlet'],
            ],
            [
                'country_iso' => 'hr',
                'name' => 'Dubrovnik',
                'description' => 'Pevnostné historické mesto nad Jadranom, vhodné na kombináciu mora a pamiatok.',
                'latitude' => 42.6507,
                'longitude' => 18.0944,
                'nearest_weather_city' => 'Dubrovnik',
                'flight_hours_from_vienna' => 1.40,
                'types' => ['more a pláž', 'historické mestá'],
            ],
            [
                'country_iso' => 'at',
                'name' => 'Vienna',
                'description' => 'Elegantné hlavné mesto s múzeami, kaviarňami, koncertmi a historickou architektúrou.',
                'latitude' => 48.2082,
                'longitude' => 16.3738,
                'nearest_weather_city' => 'Vienna',
                'flight_hours_from_vienna' => 0.00,
                'types' => ['historické mestá', 'mestský výlet'],
            ],
            [
                'country_iso' => 'cz',
                'name' => 'Prague',
                'description' => 'Romantické historické mesto s hradom, Karlovým mostom a dostupným víkendovým programom.',
                'latitude' => 50.0755,
                'longitude' => 14.4378,
                'nearest_weather_city' => 'Prague',
                'flight_hours_from_vienna' => 0.80,
                'types' => ['historické mestá', 'mestský výlet'],
            ],
            [
                'country_iso' => 'hu',
                'name' => 'Budapest',
                'description' => 'Dunajská metropola s termálnymi kúpeľmi, výhľadmi a výraznou večernou atmosférou.',
                'latitude' => 47.4979,
                'longitude' => 19.0402,
                'nearest_weather_city' => 'Budapest',
                'flight_hours_from_vienna' => 0.80,
                'types' => ['historické mestá', 'mestský výlet'],
            ],
            [
                'country_iso' => 'fr',
                'name' => 'Paris',
                'description' => 'Kultúrna metropola s ikonickými pamiatkami, galériami a mestskými prechádzkami.',
                'latitude' => 48.8566,
                'longitude' => 2.3522,
                'nearest_weather_city' => 'Paris',
                'flight_hours_from_vienna' => 2.10,
                'types' => ['historické mestá', 'mestský výlet'],
            ],
            [
                'country_iso' => 'nl',
                'name' => 'Amsterdam',
                'description' => 'Mesto kanálov, múzeí a bicyklov, vhodné na aktívny mestský výlet.',
                'latitude' => 52.3676,
                'longitude' => 4.9041,
                'nearest_weather_city' => 'Amsterdam',
                'flight_hours_from_vienna' => 2.00,
                'types' => ['mestský výlet', 'aktivity a dobrodružstvo'],
            ],
            [
                'country_iso' => 'ch',
                'name' => 'Zurich',
                'description' => 'Švajčiarske mesto pri jazere, vhodné na mestský pobyt aj výlety do prírody.',
                'latitude' => 47.3769,
                'longitude' => 8.5417,
                'nearest_weather_city' => 'Zurich',
                'flight_hours_from_vienna' => 1.40,
                'types' => ['mestský výlet', 'hory a príroda'],
            ],
            [
                'country_iso' => 'at',
                'name' => 'Innsbruck',
                'description' => 'Alpské mesto obklopené horami, vhodné na turistiku, zimné športy a prírodu.',
                'latitude' => 47.2692,
                'longitude' => 11.4041,
                'nearest_weather_city' => 'Innsbruck',
                'flight_hours_from_vienna' => 1.00,
                'types' => ['hory a príroda', 'aktivity a dobrodružstvo', 'mestský výlet'],
            ],
            [
                'country_iso' => 'ch',
                'name' => 'Zermatt',
                'description' => 'Horská destinácia pod Matterhornom, ideálna na turistiku, lyžovanie a alpské výhľady.',
                'latitude' => 46.0207,
                'longitude' => 7.7491,
                'nearest_weather_city' => 'Zermatt',
                'flight_hours_from_vienna' => 2.00,
                'types' => ['hory a príroda', 'aktivity a dobrodružstvo'],
            ],
            [
                'country_iso' => 'pt',
                'name' => 'Madeira',
                'description' => 'Zelený ostrov s miernym počasím, oceánom, levádami a prírodnými výletmi.',
                'latitude' => 32.7607,
                'longitude' => -16.9595,
                'nearest_weather_city' => 'Funchal',
                'flight_hours_from_vienna' => 4.70,
                'types' => ['hory a príroda', 'more a pláž', 'aktivity a dobrodružstvo'],
            ],
            [
                'country_iso' => 'pt',
                'name' => 'Lisbon',
                'description' => 'Atlantická metropola s výhľadmi, historickými štvrťami a dostupnými plážami v okolí.',
                'latitude' => 38.7223,
                'longitude' => -9.1393,
                'nearest_weather_city' => 'Lisbon',
                'flight_hours_from_vienna' => 3.60,
                'types' => ['historické mestá', 'mestský výlet', 'more a pláž'],
            ],
            [
                'country_iso' => 'es',
                'name' => 'Mallorca',
                'description' => 'Baleársky ostrov s plážami, horskými cestami a širokou ponukou letných aktivít.',
                'latitude' => 39.6953,
                'longitude' => 3.0176,
                'nearest_weather_city' => 'Palma',
                'flight_hours_from_vienna' => 2.40,
                'types' => ['more a pláž', 'hory a príroda', 'aktivity a dobrodružstvo'],
            ],
            [
                'country_iso' => 'tr',
                'name' => 'Istanbul',
                'description' => 'Mesto medzi Európou a Áziou s bazármi, mešitami, históriou a výraznou atmosférou.',
                'latitude' => 41.0082,
                'longitude' => 28.9784,
                'nearest_weather_city' => 'Istanbul',
                'flight_hours_from_vienna' => 2.20,
                'types' => ['historické mestá', 'mestský výlet'],
            ],
        ];

        foreach ($destinations as $destinationData) {
            $country = $countries->get($destinationData['country_iso']);

            $destination = Destination::updateOrCreate(
                [
                    'country_id' => $country->id,
                    'name' => $destinationData['name'],
                ],
                [
                    'description' => $destinationData['description'],
                    'image_url' => $this->imageUrl($destinationData['name']),
                    'latitude' => $destinationData['latitude'],
                    'longitude' => $destinationData['longitude'],
                    'nearest_weather_city' => $destinationData['nearest_weather_city'],
                    'flight_hours_from_vienna' => $destinationData['flight_hours_from_vienna'],
                ]
            );

            $typeIds = collect($destinationData['types'])
                ->map(fn (string $typeName): int => $types->get($typeName)->id)
                ->all();

            $destination->types()->sync($typeIds);
        }
    }

    private function imageUrl(string $destinationName): string
    {
        $keywords = self::IMAGE_KEYWORDS[$destinationName] ?? "{$destinationName},travel";
        $lock = 100 + array_search($destinationName, array_keys(self::IMAGE_KEYWORDS), true);

        return "https://loremflickr.com/900/620/{$keywords}?lock={$lock}";
    }
}
