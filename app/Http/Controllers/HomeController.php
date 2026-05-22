<?php

namespace App\Http\Controllers;

use App\Models\DestinationType;
use App\Services\DestinationRecommendationService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home.index', [
            'destinationTypes' => DestinationType::query()->orderBy('name')->get(),
            'temperaturePreferences' => DestinationRecommendationService::temperaturePreferenceLabels(),
            'distancePreferences' => DestinationRecommendationService::distancePreferenceLabels(),
        ]);
    }
}
