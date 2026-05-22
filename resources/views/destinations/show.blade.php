@extends('layouts.app')

@section('title', $destination->name)

@section('content')
    @php
        $monthName = \App\Services\DestinationRecommendationService::monthName($month);
        $typeNames = $destination->types->pluck('name');
        $typeText = $typeNames->join(', ');
        $avgTemp = $historicalWeather ? (float) $historicalWeather->avg_temp : null;
        $weatherPhrase = $historicalWeather
            ? "historický priemer je {$avgTemp} °C"
            : 'historické údaje pre vybraný mesiac nie sú dostupné';
        $whyNow = "{$destination->name} sa v {$monthName} hodí pre cestovateľov, ktorí hľadajú {$typeText}. V tomto období {$weatherPhrase} a let z Viedne trvá približne {$destination->flight_hours_from_vienna} hodiny.";
        $mapDestination = [
            'name' => $destination->name,
            'country' => $destination->country->name,
            'latitude' => (float) $destination->latitude,
            'longitude' => (float) $destination->longitude,
        ];
    @endphp

    <section
        class="detail-hero destination-cover"
        @if ($destination->image_url)
            style="--destination-image: url('{{ $destination->image_url }}');"
        @endif
    >
        <div class="page-kicker mb-3">Detail destinácie</div>
        <h1 class="mb-3">{{ $destination->name }}</h1>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <img
                src="https://www.geonames.org/flags/x/{{ strtolower($destination->country->iso_code) }}.gif"
                alt="{{ $destination->country->name }}"
                class="flag"
            >
            <span>{{ $destination->country->name }}</span>
            <span class="type-chip">{{ $destination->flight_hours_from_vienna }} h z Viedne</span>
        </div>
    </section>

    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4 content-lift">
        <div>
            <h2 class="h4 mb-1">Cestovný profil</h2>
            <div class="muted">Historické počasie, aktuálna predpoveď, mena a automatické vysvetlenie odporúčania.</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Nové hľadanie</a>
            @if ($searchId)
                <a href="{{ route('statistics.index') }}" class="btn btn-outline-primary">Štatistika</a>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <section class="tool-panel mb-4">
                <h2 class="section-title">Destinácia</h2>
                <p>{{ $destination->description }}</p>
                <div>
                    @foreach ($destination->types as $type)
                        <span class="type-chip">{{ $type->name }}</span>
                    @endforeach
                </div>
            </section>

            <section class="tool-panel mb-4">
                <h2 class="section-title">Poloha na mape</h2>
                <div id="destination-map" class="destination-map is-compact"></div>
            </section>

            <section class="tool-panel mb-4">
                <h2 class="section-title">Historické počasie v {{ $monthName }}</h2>
                @if ($historicalWeather)
                    <div class="weather-strip">
                        <div>
                            <span class="small muted">Priemerná teplota</span>
                            <span class="value">{{ $historicalWeather->avg_temp }} °C</span>
                        </div>
                        <div>
                            <span class="small muted">Priemerné minimum</span>
                            <span class="value">{{ $historicalWeather->min_temp }} °C</span>
                        </div>
                        <div>
                            <span class="small muted">Priemerné maximum</span>
                            <span class="value">{{ $historicalWeather->max_temp }} °C</span>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning mb-0">Historické počasie pre tento mesiac nie je uložené.</div>
                @endif
            </section>

            <section class="tool-panel">
                <h2 class="section-title">Prečo práve teraz</h2>
                <p class="mb-0">{{ $whyNow }}</p>
            </section>
        </div>

        <div class="col-lg-4">
            <section class="tool-panel mb-4">
                <h2 class="section-title">Krajina</h2>
                <dl class="row mb-0">
                    <dt class="col-5">Názov</dt>
                    <dd class="col-7">{{ $destination->country->name }}</dd>
                    <dt class="col-5">Hlavné mesto</dt>
                    <dd class="col-7">{{ $destination->country->capital }}</dd>
                    <dt class="col-5">ISO kód</dt>
                    <dd class="col-7 text-uppercase">{{ $destination->country->iso_code }}</dd>
                </dl>
            </section>

            <section class="tool-panel mb-4">
                <h2 class="section-title">Mena</h2>
                <dl class="row mb-0">
                    <dt class="col-5">Mena</dt>
                    <dd class="col-7">{{ $destination->country->currency_name }}</dd>
                    <dt class="col-5">Kód</dt>
                    <dd class="col-7">{{ $destination->country->currency_code }}</dd>
                </dl>
                @if ($currencyRate['is_eur'])
                    <div class="alert alert-light border mb-0 mt-3">Krajina používa euro, kurz k EUR sa nezobrazuje.</div>
                @elseif ($currencyRate['available'])
                    <div class="plain-metric mt-3">
                        <div class="muted small">Aktuálny kurz</div>
                        <div class="value">1 {{ $currencyRate['base'] }} = {{ number_format($currencyRate['rate'], 4, ',', ' ') }} {{ $currencyRate['quote'] }}</div>
                        @if ($currencyRate['date'])
                            <div class="muted small">Dátum kurzu: {{ $currencyRate['date'] }}</div>
                        @endif
                    </div>
                @else
                    <div class="alert alert-secondary mb-0 mt-3">{{ $currencyRate['error'] }}</div>
                @endif
            </section>

            <section class="tool-panel mb-4">
                <h2 class="section-title">Aktuálna predpoveď</h2>
                <dl class="row mb-3">
                    <dt class="col-5">Mesto</dt>
                    <dd class="col-7">
                        {{ $currentForecast['location_name'] }}
                        @if ($currentForecast['uses_fallback_city'])
                            <span class="d-block muted small">najbližšie dostupné mesto</span>
                        @endif
                    </dd>
                    <dt class="col-5">Súradnice</dt>
                    <dd class="col-7">{{ $destination->latitude }}, {{ $destination->longitude }}</dd>
                </dl>

                @if ($currentForecast['available'])
                    @php($current = $currentForecast['current'])
                    <div class="plain-metric mb-3">
                        <div class="muted small">Teraz</div>
                        <div class="value">{{ $current['temperature'] }} °C</div>
                        <div>{{ ucfirst($current['description']) }}</div>
                        <div class="muted small">
                            Pocitovo {{ $current['apparent_temperature'] }} °C,
                            vietor {{ $current['wind_speed'] }} km/h
                        </div>
                    </div>

                    @if (! empty($currentForecast['daily']))
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Dátum</th>
                                        <th>Min.</th>
                                        <th>Max.</th>
                                        <th>Stav</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($currentForecast['daily'] as $day)
                                        <tr>
                                            <td>{{ $day['date'] }}</td>
                                            <td>{{ $day['min_temp'] }} °C</td>
                                            <td>{{ $day['max_temp'] }} °C</td>
                                            <td>{{ $day['description'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @else
                    <div class="alert alert-secondary mb-0">{{ $currentForecast['error'] }}</div>
                @endif
            </section>

            <section class="tool-panel">
                <h2 class="section-title">Let z Viedne</h2>
                <div class="h3 mb-0">{{ $destination->flight_hours_from_vienna }} h</div>
            </section>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const destinationMapData = @json($mapDestination);
        const destinationMapElement = document.getElementById('destination-map');

        function escapeMapHtml(value) {
            return String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        if (destinationMapElement) {
            const map = L.map(destinationMapElement, { scrollWheelZoom: false })
                .setView([destinationMapData.latitude, destinationMapData.longitude], 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            L.marker([destinationMapData.latitude, destinationMapData.longitude])
                .addTo(map)
                .bindPopup(`<strong>${escapeMapHtml(destinationMapData.name)}</strong><br>${escapeMapHtml(destinationMapData.country)}`)
                .openPopup();
        }
    </script>
@endpush
