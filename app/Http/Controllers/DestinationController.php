<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Services\CurrencyService;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function show(
        Request $request,
        Destination $destination,
        WeatherService $weatherService,
        CurrencyService $currencyService
    ): View
    {
        $validated = $request->validate([
            'month' => ['nullable', 'integer', 'between:1,12'],
            'search' => ['nullable', 'integer', 'exists:searches,id'],
        ]);

        $month = (int) ($validated['month'] ?? now()->month);
        $destination->load(['country', 'types', 'monthlyWeather']);

        return view('destinations.show', [
            'destination' => $destination,
            'month' => $month,
            'historicalWeather' => $destination->weatherForMonth($month),
            'currentForecast' => $weatherService->forecastFor($destination),
            'currencyRate' => $currencyService->rateFromEuro($destination->country->currency_code),
            'searchId' => $validated['search'] ?? null,
        ]);
    }
}
