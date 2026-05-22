@extends('layouts.app')

@section('title', 'Štatistika')

@section('content')
    @php
        $periodLabels = [
            'morning' => '6:00–15:00',
            'afternoon' => '15:00–21:00',
            'evening' => '21:00–24:00',
            'night' => '0:00–6:00',
        ];
        $temperatureLabels = \App\Services\DestinationRecommendationService::temperaturePreferenceLabels();
        $sortLink = function (string $column) use ($sort, $direction) {
            $nextDirection = $sort === $column && $direction === 'asc' ? 'desc' : 'asc';

            return route('statistics.index', ['sort' => $column, 'direction' => $nextDirection]);
        };
    @endphp

    <section class="page-hero">
        <div class="page-kicker mb-3">Analytics</div>
        <h1>Štatistika portálu</h1>
        <p class="lead mb-0">Návštevnosť, denné obdobia, populárne destinácie a preferencie cestovateľov bez externého analytického systému.</p>
    </section>

    <div class="row g-3 mb-4 content-lift">
        <div class="col-md-6">
            <div class="metric-box">
                <div class="muted small">Celkový počet návštev</div>
                <div class="h2 mb-0">{{ $totalVisits }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="metric-box">
                <div class="muted small">Unikátne návštevy</div>
                <div class="h2 mb-0">{{ $uniqueVisits }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <section class="tool-panel h-100">
                <h2 class="section-title">Návštevnosť podľa dennej doby</h2>
                <canvas id="visitsByPeriodChart"></canvas>
            </section>
        </div>
        <div class="col-lg-6">
            <section class="tool-panel h-100">
                <h2 class="section-title">Preferencie návštevníkov</h2>
                <canvas id="preferencesChart"></canvas>
            </section>
        </div>
    </div>

    <section class="tool-panel">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-2 mb-3">
            <div>
                <h2 class="section-title mb-1">Čo ľudia hľadajú</h2>
                <div class="muted">Zobrazuje sa top 10 destinácií podľa najlepšieho výsledku vyhľadávania.</div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>
                            <a href="{{ $sortLink('destination') }}" class="link-secondary link-underline-opacity-0">
                                Destinácia
                            </a>
                        </th>
                        <th>
                            <a href="{{ $sortLink('country') }}" class="link-secondary link-underline-opacity-0">
                                Štát
                            </a>
                        </th>
                        <th class="text-end">
                            <a href="{{ $sortLink('searches') }}" class="link-secondary link-underline-opacity-0">
                                Počet hľadaní
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($popularDestinations as $destination)
                        <tr>
                            <td>{{ $destination->name }}</td>
                            <td>{{ $destination->country_name }}</td>
                            <td class="text-end">{{ $destination->searches_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center muted py-4">
                                Zatiaľ neexistujú žiadne vyhľadávania s odporúčanou destináciou.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js"></script>
    <script>
        const periodLabels = @json(array_values($periodLabels));
        const periodData = @json(collect(array_keys($periodLabels))->map(fn ($key) => $visitsByPeriod[$key] ?? 0)->values());
        const typeLabels = @json($typePreferences->pluck('name')->values());
        const typeData = @json($typePreferences->pluck('searches_count')->values());
        const temperatureLabels = @json($temperaturePreferences->pluck('temperature_preference')->map(fn ($key) => $temperatureLabels[$key] ?? $key)->values());
        const temperatureData = @json($temperaturePreferences->pluck('total')->values());

        new Chart(document.getElementById('visitsByPeriodChart'), {
            type: 'bar',
            data: {
                labels: periodLabels,
                datasets: [{
                    label: 'Návštevy',
                    data: periodData,
                    backgroundColor: '#0f766e'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });

        new Chart(document.getElementById('preferencesChart'), {
            type: 'bar',
            data: {
                labels: [...typeLabels, ...temperatureLabels],
                datasets: [{
                    label: 'Počet výberov',
                    data: [...typeData, ...temperatureData],
                    backgroundColor: [...typeLabels.map(() => '#2563eb'), ...temperatureLabels.map(() => '#b45309')]
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    </script>
@endpush
