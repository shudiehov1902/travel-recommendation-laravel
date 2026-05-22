<?php

namespace App\Http\Controllers;

use App\Models\Search;
use App\Services\DestinationRecommendationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function search(Request $request, DestinationRecommendationService $recommendationService): View
    {
        $validated = $this->validateSearchRequest($request);
        $month = $this->resolveMonth($validated);
        $validated['month'] = $month;

        $recommendations = $recommendationService->recommend($validated)
            ->take(10)
            ->values();
        $search = $this->storeSearch($validated, $recommendations);

        return view('search.results', [
            'search' => $search,
            'recommendations' => $recommendations,
            'month' => $month,
            'preferences' => $validated,
            'temperaturePreferences' => DestinationRecommendationService::temperaturePreferenceLabels(),
            'distancePreferences' => DestinationRecommendationService::distancePreferenceLabels(),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validateSearchRequest(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'month' => ['nullable', 'integer', 'between:1,12'],
            'start_date' => ['nullable', 'required_with:end_date', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:60'],
            'destination_types' => ['required', 'array', 'min:1'],
            'destination_types.*' => ['integer', 'distinct', 'exists:destination_types,id'],
            'temperature_preference' => [
                'required',
                Rule::in(DestinationRecommendationService::temperaturePreferenceKeys()),
            ],
            'distance_preference' => [
                'required',
                Rule::in(DestinationRecommendationService::distancePreferenceKeys()),
            ],
        ]);

        $validator->after(function ($validator): void {
            $data = $validator->getData();

            if (empty($data['month']) && empty($data['start_date'])) {
                $validator->errors()->add('month', 'Vyberte mesiac alebo konkrétny dátum odchodu.');
            }
        });

        return $validator->validate();
    }

    /**
     * @param array<string, mixed> $validated
     */
    private function resolveMonth(array $validated): int
    {
        if (! empty($validated['month'])) {
            return (int) $validated['month'];
        }

        if (! empty($validated['start_date'])) {
            return Carbon::parse($validated['start_date'])->month;
        }

        throw ValidationException::withMessages([
            'month' => 'Vyberte mesiac alebo dátum odchodu.',
        ]);
    }

    /**
     * @param array<string, mixed> $validated
     */
    private function storeSearch(array $validated, $recommendations): Search
    {
        $search = Search::create([
            'destination_id' => $recommendations->first()['destination']->id ?? null,
            'month' => $validated['month'],
            'duration_days' => $validated['duration_days'],
            'temperature_preference' => $validated['temperature_preference'],
            'distance_preference' => $validated['distance_preference'],
        ]);

        $search->types()->sync($validated['destination_types']);

        $search->recommendedDestinations()->sync(
            $recommendations
                ->mapWithKeys(fn (array $recommendation): array => [
                    $recommendation['destination']->id => ['score' => $recommendation['score']],
                ])
                ->all()
        );

        return $search->load(['types', 'recommendedDestinations']);
    }
}
