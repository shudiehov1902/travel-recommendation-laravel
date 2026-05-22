<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class CurrencyService
{
    /**
     * @return array{
     *     available: bool,
     *     is_eur: bool,
     *     base: string,
     *     quote: string,
     *     rate: float|null,
     *     date: string|null,
     *     error: string|null
     * }
     */
    public function rateFromEuro(string $currencyCode): array
    {
        $currencyCode = strtoupper($currencyCode);

        if ($currencyCode === 'EUR') {
            return [
                'available' => true,
                'is_eur' => true,
                'base' => 'EUR',
                'quote' => 'EUR',
                'rate' => null,
                'date' => null,
                'error' => null,
            ];
        }

        $cacheKey = "currency.eur.{$currencyCode}";

        try {
            $cachedRate = Cache::get($cacheKey);

            if (is_array($cachedRate)) {
                return $cachedRate;
            }
        } catch (Throwable) {
            // Currency lookup must still continue when the cache store is unavailable.
        }

        try {
            $response = Http::timeout(6)
                ->acceptJson()
                ->get(config('services.frankfurter.rates_url'), [
                    'base' => 'EUR',
                    'quotes' => $currencyCode,
                ]);

            if ($response->failed()) {
                return $this->unavailable($currencyCode);
            }

            $data = $response->json();
            $rateRow = is_array($data) ? ($data[0] ?? null) : null;

            if (! is_array($rateRow) || ! isset($rateRow['rate'])) {
                return $this->unavailable($currencyCode);
            }

            $rate = [
                'available' => true,
                'is_eur' => false,
                'base' => $rateRow['base'] ?? 'EUR',
                'quote' => $rateRow['quote'] ?? $currencyCode,
                'rate' => (float) $rateRow['rate'],
                'date' => $rateRow['date'] ?? null,
                'error' => null,
            ];

            $this->cacheRate($cacheKey, $rate);

            return $rate;
        } catch (Throwable) {
            return $this->unavailable($currencyCode);
        }
    }

    private function cacheRate(string $cacheKey, array $rate): void
    {
        try {
            Cache::put(
                $cacheKey,
                $rate,
                now()->addSeconds((int) config('services.frankfurter.cache_ttl', 3600))
            );
        } catch (Throwable) {
            // Rate is still returned; caching only reduces repeated API calls.
        }
    }

    private function unavailable(string $currencyCode): array
    {
        return [
            'available' => false,
            'is_eur' => false,
            'base' => 'EUR',
            'quote' => $currencyCode,
            'rate' => null,
            'date' => null,
            'error' => 'Aktuálny kurz meny je dočasne nedostupný.',
        ];
    }
}
