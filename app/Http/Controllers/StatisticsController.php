<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\DestinationType;
use App\Models\Search;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    public function index(Request $request): View
    {
        $sort = $request->query('sort', 'searches');
        $direction = $request->query('direction') === 'asc' ? 'asc' : 'desc';

        return view('statistics.index', [
            'totalVisits' => Visit::query()->count(),
            'uniqueVisits' => Visit::query()->where('is_unique', true)->count(),
            'visitsByPeriod' => $this->visitsByPeriod(),
            'popularDestinations' => $this->popularDestinations($sort, $direction),
            'typePreferences' => DestinationType::query()
                ->withCount('searches')
                ->orderByDesc('searches_count')
                ->get(),
            'temperaturePreferences' => Search::query()
                ->select('temperature_preference', DB::raw('COUNT(*) as total'))
                ->groupBy('temperature_preference')
                ->orderByDesc('total')
                ->get(),
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    private function visitsByPeriod(): array
    {
        $emptyPeriods = [
            'morning' => 0,
            'afternoon' => 0,
            'evening' => 0,
            'night' => 0,
        ];

        $counts = Visit::query()
            ->select('time_period', DB::raw('COUNT(*) as total'))
            ->groupBy('time_period')
            ->pluck('total', 'time_period')
            ->all();

        return array_merge($emptyPeriods, $counts);
    }

    private function popularDestinations(string $sort, string $direction)
    {
        $destinations = Destination::query()
            ->select([
                'destinations.id',
                'destinations.name',
                'countries.name as country_name',
                DB::raw('COUNT(searches.id) as searches_count'),
            ])
            ->join('countries', 'countries.id', '=', 'destinations.country_id')
            ->join('searches', 'searches.destination_id', '=', 'destinations.id')
            ->groupBy('destinations.id', 'destinations.name', 'countries.name')
            ->orderByDesc('searches_count')
            ->orderBy('destinations.name')
            ->limit(10)
            ->get();

        return $destinations
            ->sort(function ($first, $second) use ($sort, $direction): int {
                $multiplier = $direction === 'asc' ? 1 : -1;

                if ($sort === 'destination') {
                    return $multiplier * strcasecmp($first->name, $second->name);
                }

                if ($sort === 'country') {
                    $countryCompare = strcasecmp($first->country_name, $second->country_name);

                    if ($countryCompare !== 0) {
                        return $multiplier * $countryCompare;
                    }

                    return strcasecmp($first->name, $second->name);
                }

                $countCompare = $first->searches_count <=> $second->searches_count;

                if ($countCompare !== 0) {
                    return $multiplier * $countCompare;
                }

                return strcasecmp($first->name, $second->name);
            })
            ->values();
    }
}
