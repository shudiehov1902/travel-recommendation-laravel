<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\DestinationType;
use App\Models\Search;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TravelFlowTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_search_returns_recommendations_and_stores_statistics_data(): void
    {
        $beachType = DestinationType::where('name', 'more a pláž')->firstOrFail();
        $cityType = DestinationType::where('name', 'mestský výlet')->firstOrFail();

        $response = $this->post('/search', [
            'month' => 7,
            'duration_days' => 7,
            'destination_types' => [$beachType->id, $cityType->id],
            'temperature_preference' => 'warm',
            'distance_preference' => 'up_to_3',
        ]);

        $response->assertOk();
        $response->assertSee('Odporúčané destinácie');
        $response->assertSee('Spĺňa typ dovolenky');

        $this->assertDatabaseCount('searches', 1);
        $this->assertDatabaseHas('search_type', [
            'destination_type_id' => $beachType->id,
        ]);
        $this->assertGreaterThan(0, Search::firstOrFail()->recommendedDestinations()->count());
        $this->assertGreaterThan(0, Visit::count());
    }

    public function test_compare_requires_exactly_two_destinations(): void
    {
        $ids = Destination::query()->limit(3)->pluck('id')->all();

        $response = $this->from('/')->post('/compare', [
            'month' => 7,
            'destination_ids' => $ids,
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors('destination_ids');
    }

    public function test_destination_detail_uses_external_api_data_when_available(): void
    {
        Http::fake([
            'api.open-meteo.com/*' => Http::response([
                'current' => [
                    'time' => '2026-05-05T12:00',
                    'temperature_2m' => 21.4,
                    'apparent_temperature' => 22.1,
                    'weather_code' => 1,
                    'wind_speed_10m' => 8.5,
                ],
                'daily' => [
                    'time' => ['2026-05-05', '2026-05-06', '2026-05-07'],
                    'temperature_2m_max' => [24.2, 23.9, 25.1],
                    'temperature_2m_min' => [15.3, 14.8, 16.0],
                    'weather_code' => [1, 2, 3],
                ],
            ]),
            'api.frankfurter.dev/*' => Http::response([
                [
                    'date' => '2026-05-04',
                    'base' => 'EUR',
                    'quote' => 'CHF',
                    'rate' => 0.95,
                ],
            ]),
        ]);

        $destination = Destination::where('name', 'Zurich')->firstOrFail();

        $response = $this->get(route('destinations.show', [
            'destination' => $destination,
            'month' => 7,
        ]));

        $response->assertOk();
        $response->assertSee('Zurich');
        $response->assertSee('Aktuálny kurz');
        $response->assertSee('0,9500 CHF');
        $response->assertSee('21.4 °C');
        $response->assertSee('Prečo práve teraz');
    }
}
