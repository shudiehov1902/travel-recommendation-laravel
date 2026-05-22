<?php

namespace App\Services;

use App\Models\Destination;
use Illuminate\Support\Collection;

class DestinationRecommendationService
{
    public const TEMPERATURE_HOT = 'hot';
    public const TEMPERATURE_WARM = 'warm';
    public const TEMPERATURE_MILD = 'mild';
    public const TEMPERATURE_ANY = 'any';

    public const DISTANCE_UP_TO_3 = 'up_to_3';
    public const DISTANCE_UP_TO_5 = 'up_to_5';
    public const DISTANCE_ANYWHERE = 'anywhere';

    /**
     * @param array{
     *     month:int|null,
     *     duration_days:int,
     *     destination_types:array<int>,
     *     temperature_preference:string,
     *     distance_preference:string
     * } $preferences
     * @return Collection<int, array{destination: Destination, score: int, reasons: array<int, string>}>
     */
    public function recommend(array $preferences): Collection
    {
        $typeIds = collect($preferences['destination_types'] ?? [])->map(fn ($id): int => (int) $id);
        $month = isset($preferences['month']) ? (int) $preferences['month'] : null;

        return Destination::query()
            ->with(['country', 'types', 'monthlyWeather'])
            ->get()
            ->map(function (Destination $destination) use ($preferences, $typeIds, $month): array {
                [$score, $reasons] = $this->scoreDestination($destination, $preferences, $typeIds, $month);

                return [
                    'destination' => $destination,
                    'score' => $score,
                    'reasons' => $reasons,
                ];
            })
            ->filter(fn (array $recommendation): bool => $recommendation['score'] > 0)
            ->sortByDesc('score')
            ->values();
    }

    public static function temperaturePreferenceKeys(): array
    {
        return [
            self::TEMPERATURE_HOT,
            self::TEMPERATURE_WARM,
            self::TEMPERATURE_MILD,
            self::TEMPERATURE_ANY,
        ];
    }

    public static function distancePreferenceKeys(): array
    {
        return [
            self::DISTANCE_UP_TO_3,
            self::DISTANCE_UP_TO_5,
            self::DISTANCE_ANYWHERE,
        ];
    }

    public static function temperaturePreferenceLabels(): array
    {
        return [
            self::TEMPERATURE_HOT => 'horúco: 30 °C+',
            self::TEMPERATURE_WARM => 'teplo: 20–29 °C',
            self::TEMPERATURE_MILD => 'príjemne: 10–19 °C',
            self::TEMPERATURE_ANY => 'jedno mi to',
        ];
    }

    public static function distancePreferenceLabels(): array
    {
        return [
            self::DISTANCE_UP_TO_3 => 'do 3 hodín letu',
            self::DISTANCE_UP_TO_5 => 'do 5 hodín letu',
            self::DISTANCE_ANYWHERE => 'kdekoľvek',
        ];
    }

    public static function monthName(int $month): string
    {
        return [
            1 => 'januári',
            2 => 'februári',
            3 => 'marci',
            4 => 'apríli',
            5 => 'máji',
            6 => 'júni',
            7 => 'júli',
            8 => 'auguste',
            9 => 'septembri',
            10 => 'októbri',
            11 => 'novembri',
            12 => 'decembri',
        ][$month] ?? (string) $month;
    }

    private function scoreDestination(Destination $destination, array $preferences, Collection $typeIds, ?int $month): array
    {
        $score = 0;
        $reasons = [];

        [$typeScore, $typeReasons] = $this->scoreTypes($destination, $typeIds);
        $score += $typeScore;
        $reasons = [...$reasons, ...$typeReasons];

        [$temperatureScore, $temperatureReasons] = $this->scoreTemperature(
            $destination,
            $preferences['temperature_preference'],
            $month
        );
        $score += $temperatureScore;
        $reasons = [...$reasons, ...$temperatureReasons];

        [$distanceScore, $distanceReasons] = $this->scoreDistance(
            $destination,
            $preferences['distance_preference']
        );
        $score += $distanceScore;
        $reasons = [...$reasons, ...$distanceReasons];

        [$durationScore, $durationReasons] = $this->scoreDuration(
            $destination,
            (int) $preferences['duration_days']
        );
        $score += $durationScore;
        $reasons = [...$reasons, ...$durationReasons];

        return [$score, $reasons];
    }

    private function scoreTypes(Destination $destination, Collection $typeIds): array
    {
        $matchedTypes = $destination->types
            ->filter(fn ($type): bool => $typeIds->contains($type->id))
            ->pluck('name')
            ->values();

        if ($matchedTypes->isEmpty()) {
            return [0, []];
        }

        $reasons = $matchedTypes
            ->map(fn (string $type): string => "Spĺňa typ dovolenky: {$type}")
            ->all();

        return [30 + ($matchedTypes->count() * 10), $reasons];
    }

    private function scoreTemperature(Destination $destination, string $preference, ?int $month): array
    {
        if ($month === null) {
            return [0, []];
        }

        $weather = $destination->weatherForMonth($month);

        if ($weather === null) {
            return [0, []];
        }

        $avgTemp = (float) $weather->avg_temp;
        $monthName = self::monthName($month);
        $reasons = ["Má historické údaje o počasí pre mesiac {$monthName}."];

        if ($preference === self::TEMPERATURE_ANY) {
            $reasons[] = "Priemerná teplota v {$monthName} je {$avgTemp} °C.";

            return [20, $reasons];
        }

        if ($this->temperatureMatchesPreference($avgTemp, $preference)) {
            $reasons[] = "Priemerná teplota v {$monthName} je {$avgTemp} °C a zodpovedá preferencii.";

            return [40, $reasons];
        }

        $reasons[] = "Priemerná teplota v {$monthName} je {$avgTemp} °C.";

        return [10, $reasons];
    }

    private function scoreDistance(Destination $destination, string $preference): array
    {
        $flightHours = (float) $destination->flight_hours_from_vienna;

        if ($preference === self::DISTANCE_ANYWHERE) {
            return [15, ["Let z Viedne trvá približne {$flightHours} hodiny."]];
        }

        if ($preference === self::DISTANCE_UP_TO_3 && $flightHours <= 3) {
            return [30, ["Let z Viedne trvá približne {$flightHours} hodiny, teda do 3 hodín."]];
        }

        if ($preference === self::DISTANCE_UP_TO_5 && $flightHours <= 5) {
            return [30, ["Let z Viedne trvá približne {$flightHours} hodiny, teda do 5 hodín."]];
        }

        return [0, []];
    }

    private function scoreDuration(Destination $destination, int $durationDays): array
    {
        $typeNames = $destination->types->pluck('name');

        if ($durationDays <= 3 && $typeNames->intersect(['mestský výlet', 'historické mestá'])->isNotEmpty()) {
            return [10, ['Destinácia je vhodná aj na kratší mestský pobyt.']];
        }

        if ($durationDays >= 7 && $typeNames->intersect(['more a pláž', 'hory a príroda'])->isNotEmpty()) {
            return [10, ['Dĺžka pobytu sa hodí na oddych alebo aktivity v prírode.']];
        }

        if ($durationDays >= 4 && $durationDays <= 6) {
            return [5, ['Dĺžka pobytu je univerzálna pre túto destináciu.']];
        }

        return [0, []];
    }

    private function temperatureMatchesPreference(float $avgTemp, string $preference): bool
    {
        return match ($preference) {
            self::TEMPERATURE_HOT => $avgTemp >= 30,
            self::TEMPERATURE_WARM => $avgTemp >= 20 && $avgTemp <= 29,
            self::TEMPERATURE_MILD => $avgTemp >= 10 && $avgTemp <= 19,
            default => false,
        };
    }
}
