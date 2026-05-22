@extends('layouts.app')

@section('title', 'Odporúčané destinácie')

@section('content')
    @php
        $mapDestinations = $recommendations
            ->map(function (array $recommendation) use ($month, $search) {
                $destination = $recommendation['destination'];
                $weather = $destination->weatherForMonth($month);

                return [
                    'id' => $destination->id,
                    'name' => $destination->name,
                    'country' => $destination->country->name,
                    'latitude' => (float) $destination->latitude,
                    'longitude' => (float) $destination->longitude,
                    'score' => (int) $recommendation['score'],
                    'avg_temp' => $weather ? (float) $weather->avg_temp : null,
                    'url' => route('destinations.show', [
                        'destination' => $destination,
                        'month' => $month,
                        'search' => $search->id,
                    ]),
                ];
            })
            ->values();
    @endphp

    <section class="page-hero">
        <div class="page-kicker mb-3">Výsledky hľadania</div>
        <h1>Destinácie zoradené podľa zhody</h1>
        <p class="lead mb-0">
            {{ ucfirst(\App\Services\DestinationRecommendationService::monthName($month)) }},
            {{ $preferences['duration_days'] }} dní,
            {{ $temperaturePreferences[$preferences['temperature_preference']] }},
            {{ $distancePreferences[$preferences['distance_preference']] }}.
        </p>
    </section>

    <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4 content-lift">
        <div>
            <h2 class="h4 mb-1">Odporúčané destinácie</h2>
            <div class="muted">Každá karta ukazuje, prečo sa miesto dostalo do výberu.</div>
        </div>
        <div>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Upraviť hľadanie</a>
        </div>
    </div>

    @if ($recommendations->isEmpty())
        <div class="alert alert-warning">Pre zadané kritériá sa nenašla vhodná destinácia.</div>
    @else
        <section class="tool-panel mb-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-2 mb-3">
                <div>
                    <h2 class="section-title mb-1">Mapa odporúčaní</h2>
                    <div class="muted">Top 10 destinácií z výsledkov hľadania podľa ich polohy.</div>
                </div>
            </div>
            <div id="results-map" class="destination-map"></div>
        </section>

        <form action="{{ route('compare') }}" method="POST" id="compare-form">
            @csrf
            <input type="hidden" name="month" value="{{ $month }}">

            <div class="row g-3">
                @foreach ($recommendations as $recommendation)
                    @php
                        $destination = $recommendation['destination'];
                        $weather = $destination->weatherForMonth($month);
                    @endphp

                    <div class="col-md-6">
                        <article class="result-card">
                            @if ($destination->image_url)
                                <div class="destination-photo">
                                    <img src="{{ $destination->image_url }}" alt="{{ $destination->name }}" loading="lazy">
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <h2 class="h4 mb-1">{{ $destination->name }}</h2>
                                    <div class="muted">{{ $destination->country->name }}</div>
                                </div>
                                <span class="score-badge">{{ $recommendation['score'] }} bodov</span>
                            </div>

                            <p class="mt-3 mb-3">{{ $destination->description }}</p>

                            <div class="mb-3">
                                @foreach ($destination->types as $type)
                                    <span class="type-chip">{{ $type->name }}</span>
                                @endforeach
                            </div>

                            @if ($weather)
                                <div class="weather-strip mb-3">
                                    <div>
                                        <span class="small muted">Priemer</span>
                                        <span class="value">{{ $weather->avg_temp }} °C</span>
                                    </div>
                                    <div>
                                        <span class="small muted">Min.</span>
                                        <span class="value">{{ $weather->min_temp }} °C</span>
                                    </div>
                                    <div>
                                        <span class="small muted">Max.</span>
                                        <span class="value">{{ $weather->max_temp }} °C</span>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <div class="fw-semibold mb-2">Prečo sa hodí</div>
                                <ul class="reason-list mb-0">
                                    @foreach ($recommendation['reasons'] as $reason)
                                        <li>{{ $reason }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="destination_ids[]"
                                        value="{{ $destination->id }}"
                                        id="compare-{{ $destination->id }}"
                                        data-compare-checkbox
                                    >
                                    <label class="form-check-label" for="compare-{{ $destination->id }}">Porovnať</label>
                                </div>

                                <a
                                    class="btn btn-outline-primary"
                                    href="{{ route('destinations.show', ['destination' => $destination, 'month' => $month, 'search' => $search->id]) }}"
                                >
                                    Detail
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="tool-panel sticky-compare mt-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <div class="fw-semibold">Porovnanie destinácií</div>
                    <div class="muted small">Označte presne dve destinácie zo zoznamu.</div>
                    <div class="small compare-status" id="compare-status">Vybrané: 0/2</div>
                </div>
                <button type="submit" class="btn btn-primary" id="compare-submit" disabled>Porovnať vybrané</button>
            </div>
        </form>
    @endif
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const resultMapDestinations = @json($mapDestinations ?? []);

        function escapeHtml(value) {
            return String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        const mapElement = document.getElementById('results-map');

        if (mapElement && resultMapDestinations.length > 0) {
            const map = L.map(mapElement, { scrollWheelZoom: false });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const bounds = [];

            resultMapDestinations.forEach((destination) => {
                const position = [destination.latitude, destination.longitude];
                bounds.push(position);

                const temperature = destination.avg_temp === null
                    ? 'historická teplota nie je dostupná'
                    : `${destination.avg_temp} °C`;

                L.marker(position)
                    .addTo(map)
                    .bindPopup(`
                        <h3 class="map-popup-title">${escapeHtml(destination.name)}</h3>
                        <div class="map-popup-meta">${escapeHtml(destination.country)}</div>
                        <div class="map-popup-meta">Score: ${destination.score} bodov</div>
                        <div class="map-popup-meta">Priemer: ${escapeHtml(temperature)}</div>
                        <a href="${destination.url}" class="btn btn-sm btn-primary mt-2">Detail</a>
                    `);
            });

            map.fitBounds(bounds, { padding: [28, 28], maxZoom: 7 });
        }

        const compareForm = document.getElementById('compare-form');
        const compareCheckboxes = [...document.querySelectorAll('[data-compare-checkbox]')];
        const compareSubmit = document.getElementById('compare-submit');
        const compareStatus = document.getElementById('compare-status');

        function updateCompareState(changedCheckbox = null) {
            let checked = compareCheckboxes.filter((checkbox) => checkbox.checked);

            if (checked.length > 2 && changedCheckbox) {
                changedCheckbox.checked = false;
                checked = compareCheckboxes.filter((checkbox) => checkbox.checked);
            }

            compareCheckboxes.forEach((checkbox) => {
                checkbox.disabled = !checkbox.checked && checked.length >= 2;
            });

            if (compareSubmit) {
                compareSubmit.disabled = checked.length !== 2;
            }

            if (compareStatus) {
                compareStatus.textContent = `Vybrané: ${checked.length}/2`;
                compareStatus.classList.toggle('text-danger', checked.length !== 2);
                compareStatus.classList.toggle('text-success', checked.length === 2);
            }
        }

        compareCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', () => updateCompareState(checkbox));
        });

        compareForm?.addEventListener('submit', (event) => {
            const checked = compareCheckboxes.filter((checkbox) => checkbox.checked);

            if (checked.length !== 2) {
                event.preventDefault();
                updateCompareState();
            }
        });

        updateCompareState();
    </script>
@endpush
