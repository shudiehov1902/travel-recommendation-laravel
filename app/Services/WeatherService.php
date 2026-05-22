<?php

namespace App\Services;

use App\Models\Destination;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class WeatherService
{
    /**
     * @return array{
     *     available: bool,
     *     location_name: string,
     *     uses_fallback_city: bool,
     *     current: array<string, mixed>|null,
     *     daily: array<int, array<string, mixed>>,
     *     error: string|null
     * }
     */
    public function forecastFor(Destination $destination): array
    {
        $locationName = $destination->nearest_weather_city ?: $destination->name;
        $usesFallbackCity = strcasecmp($locationName, $destination->name) !== 0;
        $cacheKey = $this->cacheKey($destination);

        try {
            $cachedForecast = Cache::get($cacheKey);

            if (is_array($cachedForecast)) {
                return $cachedForecast;
            }
        } catch (Throwable) {
            // The API should still work even when the cache store is temporarily unavailable.
        }

        try {
            $response = Http::timeout(6)
                ->acceptJson()
                ->get(config('services.open_meteo.forecast_url'), [
                    'latitude' => (float) $destination->latitude,
                    'longitude' => (float) $destination->longitude,
                    'current' => 'temperature_2m,apparent_temperature,weather_code,wind_speed_10m',
                    'daily' => 'temperature_2m_max,temperature_2m_min,weather_code',
                    'forecast_days' => 3,
                    'timezone' => 'auto',
                ]);

            if ($response->failed()) {
                return $this->unavailable($locationName, $usesFallbackCity);
            }

            $data = $response->json();

            if (! is_array($data) || empty($data['current'])) {
                return $this->unavailable($locationName, $usesFallbackCity);
            }

            $forecast = [
                'available' => true,
                'location_name' => $locationName,
                'uses_fallback_city' => $usesFallbackCity,
                'current' => $this->currentWeather($data['current']),
                'daily' => $this->dailyForecast($data['daily'] ?? []),
                'error' => null,
            ];

            $this->cacheForecast($cacheKey, $forecast);

            return $forecast;
        } catch (Throwable) {
            return $this->unavailable($locationName, $usesFallbackCity);
        }
    }

    private function cacheKey(Destination $destination): string
    {
        return sprintf(
            'weather.forecast.%d.%s.%s',
            $destination->id,
            round((float) $destination->latitude, 4),
            round((float) $destination->longitude, 4)
        );
    }

    private function cacheForecast(string $cacheKey, array $forecast): void
    {
        try {
            Cache::put(
                $cacheKey,
                $forecast,
                now()->addSeconds((int) config('services.open_meteo.cache_ttl', 3600))
            );
        } catch (Throwable) {
            // Forecast is still returned; caching is an optimization, not a dependency.
        }
    }

    private function currentWeather(array $current): array
    {
        $weatherCode = $current['weather_code'] ?? null;

        return [
            'time' => $current['time'] ?? null,
            'temperature' => $current['temperature_2m'] ?? null,
            'apparent_temperature' => $current['apparent_temperature'] ?? null,
            'wind_speed' => $current['wind_speed_10m'] ?? null,
            'weather_code' => $weatherCode,
            'description' => $this->describeWeatherCode($weatherCode),
        ];
    }

    private function dailyForecast(array $daily): array
    {
        $dates = $daily['time'] ?? [];
        $maxTemps = $daily['temperature_2m_max'] ?? [];
        $minTemps = $daily['temperature_2m_min'] ?? [];
        $weatherCodes = $daily['weather_code'] ?? [];

        return collect($dates)
            ->take(3)
            ->map(fn (string $date, int $index): array => [
                'date' => $date,
                'min_temp' => $minTemps[$index] ?? null,
                'max_temp' => $maxTemps[$index] ?? null,
                'weather_code' => $weatherCodes[$index] ?? null,
                'description' => $this->describeWeatherCode($weatherCodes[$index] ?? null),
            ])
            ->values()
            ->all();
    }

    private function unavailable(string $locationName, bool $usesFallbackCity): array
    {
        return [
            'available' => false,
            'location_name' => $locationName,
            'uses_fallback_city' => $usesFallbackCity,
            'current' => null,
            'daily' => [],
            'error' => 'Aktuálna predpoveď počasia je dočasne nedostupná.',
        ];
    }

    private function describeWeatherCode(null|int|string $code): string
    {
        if ($code === null || $code === '') {
            return 'neznámy stav počasia';
        }

        return match ((int) $code) {
            0 => 'jasno',
            1, 2, 3 => 'prevažne jasno až oblačno',
            45, 48 => 'hmla',
            51, 53, 55 => 'mrholenie',
            56, 57 => 'mrznúce mrholenie',
            61, 63, 65 => 'dážď',
            66, 67 => 'mrznúci dážď',
            71, 73, 75 => 'sneženie',
            77 => 'snehové zrná',
            80, 81, 82 => 'prehánky',
            85, 86 => 'snehové prehánky',
            95 => 'búrka',
            96, 99 => 'búrka s krúpami',
            default => 'neznámy stav počasia',
        };
    }
}
