<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\MonthlyWeather;
use Illuminate\Database\Seeder;

class MonthlyWeatherSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = Destination::all()->keyBy('name');

        $averageTemperatures = [
            'Barcelona' => [10, 11, 13, 15, 18, 22, 25, 26, 23, 19, 14, 11],
            'Valencia' => [11, 12, 14, 16, 19, 23, 26, 26, 24, 20, 15, 12],
            'Rome' => [8, 9, 12, 15, 19, 23, 26, 26, 22, 18, 13, 9],
            'Florence' => [6, 8, 11, 14, 18, 22, 25, 25, 21, 16, 11, 7],
            'Athens' => [10, 11, 13, 17, 22, 27, 30, 30, 26, 21, 16, 12],
            'Santorini' => [12, 13, 15, 18, 22, 26, 28, 28, 25, 21, 17, 14],
            'Split' => [8, 9, 12, 16, 20, 24, 27, 27, 23, 18, 13, 9],
            'Dubrovnik' => [9, 10, 12, 15, 20, 24, 27, 27, 23, 18, 14, 10],
            'Vienna' => [1, 3, 7, 12, 17, 20, 22, 22, 17, 12, 6, 2],
            'Prague' => [0, 2, 6, 11, 16, 19, 21, 20, 16, 10, 5, 1],
            'Budapest' => [1, 3, 8, 13, 18, 22, 24, 24, 19, 13, 7, 2],
            'Paris' => [5, 6, 9, 12, 16, 19, 21, 21, 18, 13, 8, 6],
            'Amsterdam' => [4, 4, 7, 10, 14, 17, 19, 18, 16, 12, 8, 5],
            'Zurich' => [1, 2, 6, 10, 14, 18, 20, 19, 15, 10, 5, 2],
            'Innsbruck' => [-1, 1, 5, 9, 14, 17, 19, 18, 14, 9, 4, 0],
            'Zermatt' => [-6, -5, -2, 1, 5, 9, 12, 11, 8, 4, -1, -5],
            'Madeira' => [16, 16, 17, 17, 19, 21, 23, 24, 23, 22, 19, 17],
            'Lisbon' => [11, 12, 14, 15, 18, 21, 23, 24, 23, 19, 15, 12],
            'Mallorca' => [10, 11, 13, 15, 19, 23, 26, 26, 23, 19, 14, 11],
            'Istanbul' => [6, 6, 8, 12, 17, 22, 25, 25, 21, 16, 12, 8],
        ];

        foreach ($averageTemperatures as $destinationName => $monthlyAverages) {
            $destination = $destinations->get($destinationName);

            foreach ($monthlyAverages as $index => $avgTemp) {
                $month = $index + 1;
                $offset = $this->temperatureOffset($avgTemp);

                MonthlyWeather::updateOrCreate(
                    [
                        'destination_id' => $destination->id,
                        'month' => $month,
                    ],
                    [
                        'avg_temp' => $avgTemp,
                        'min_temp' => round($avgTemp - $offset, 1),
                        'max_temp' => round($avgTemp + $offset, 1),
                    ]
                );
            }
        }
    }

    private function temperatureOffset(float|int $avgTemp): float
    {
        return match (true) {
            $avgTemp >= 25 => 5.0,
            $avgTemp >= 18 => 4.5,
            $avgTemp >= 8 => 4.0,
            $avgTemp >= 0 => 3.5,
            default => 4.0,
        };
    }
}
