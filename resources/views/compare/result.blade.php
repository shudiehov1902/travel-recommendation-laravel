@extends('layouts.app')

@section('title', 'Porovnanie destinácií')

@section('content')
    <section class="page-hero">
        <div class="page-kicker mb-3">Side by side</div>
        <h1>Porovnanie destinácií</h1>
        <p class="lead mb-0">Rýchly pohľad na počasie, menu, typ pobytu, krajinu a let z Viedne.</p>
    </section>

    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4 content-lift">
        <div>
            <h2 class="h4 mb-1">Mesiac: {{ ucfirst(\App\Services\DestinationRecommendationService::monthName($month)) }}</h2>
            <div class="muted">Vybrané miesta sú zoradené tak, ako boli označené vo výsledkoch.</div>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary align-self-start">Nové hľadanie</a>
    </div>

    <div class="table-responsive tool-panel">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Kritérium</th>
                    @foreach ($destinations as $destination)
                        <th>
                            <div class="comparison-heading">
                                @if ($destination->image_url)
                                    <div class="comparison-thumb-wrap">
                                        <img src="{{ $destination->image_url }}" alt="{{ $destination->name }}" class="comparison-thumb" loading="lazy">
                                    </div>
                                @endif
                                {{ $destination->name }}
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Krajina</th>
                    @foreach ($destinations as $destination)
                        <td>
                            <img
                                src="https://www.geonames.org/flags/x/{{ strtolower($destination->country->iso_code) }}.gif"
                                alt="{{ $destination->country->name }}"
                                class="flag me-2"
                            >
                            {{ $destination->country->name }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <th>Typ destinácie</th>
                    @foreach ($destinations as $destination)
                        <td>
                            @foreach ($destination->types as $type)
                                <span class="type-chip">{{ $type->name }}</span>
                            @endforeach
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <th>Počasie</th>
                    @foreach ($destinations as $destination)
                        @php($weather = $destination->weatherForMonth($month))
                        <td>
                            @if ($weather)
                                Priemer {{ $weather->avg_temp }} °C<br>
                                Min. {{ $weather->min_temp }} °C<br>
                                Max. {{ $weather->max_temp }} °C
                            @else
                                Nie je dostupné
                            @endif
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <th>Mena</th>
                    @foreach ($destinations as $destination)
                        <td>{{ $destination->country->currency_name }} ({{ $destination->country->currency_code }})</td>
                    @endforeach
                </tr>
                <tr>
                    <th>Let z Viedne</th>
                    @foreach ($destinations as $destination)
                        <td>{{ $destination->flight_hours_from_vienna }} h</td>
                    @endforeach
                </tr>
                <tr>
                    <th>Detail</th>
                    @foreach ($destinations as $destination)
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('destinations.show', ['destination' => $destination, 'month' => $month]) }}">
                                Otvoriť
                            </a>
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
@endsection
