@extends('layouts.app')

@section('title', 'Vyhľadávanie dovolenky')

@section('content')
    <section class="page-hero">
        <div class="page-kicker mb-3">Travel matcher</div>
        <h1>Kam sa oplatí ísť práve teraz?</h1>
        <p class="lead mb-4">Vyberte náladu dovolenky a aplikácia zoradí destinácie podľa počasia, typu pobytu a letu z Viedne.</p>
        <div class="hero-facts">
            <div class="hero-fact">
                <strong>20</strong>
                <span>destinácií</span>
            </div>
            <div class="hero-fact">
                <strong>240</strong>
                <span>mesačných teplôt</span>
            </div>
            <div class="hero-fact">
                <strong>2 API</strong>
                <span>počasie a kurzy</span>
            </div>
        </div>
    </section>

    <div class="row align-items-start g-4 content-lift">
        <div class="col-lg-4">
            <div class="tool-panel">
                <div class="page-kicker text-uppercase mb-2" style="color: var(--brand);">Ako to funguje</div>
                <h2 class="h4 mb-3">Čo od dovolenky chcem?</h2>
                <p class="muted mb-0">Formulár vytvorí profil cesty a odporúčací servis pridelí body za zhodu typu dovolenky, počasia, mesiaca a vzdialenosti letu.</p>
            </div>
        </div>

        <div class="col-lg-8">
            <form action="{{ route('search') }}" method="POST" class="tool-panel">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="month" class="form-label">Mesiac</label>
                        <select name="month" id="month" class="form-select">
                            <option value="">Vyberte mesiac</option>
                            @foreach (range(1, 12) as $month)
                                <option value="{{ $month }}" @selected((string) old('month') === (string) $month)>
                                    {{ ucfirst(\App\Services\DestinationRecommendationService::monthName($month)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Od</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label for="end_date" class="form-label">Do</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label for="duration_days" class="form-label">Počet dní</label>
                        <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days', 5) }}" min="1" max="60" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label for="temperature_preference" class="form-label">Teplota</label>
                        <select name="temperature_preference" id="temperature_preference" class="form-select" required>
                            @foreach ($temperaturePreferences as $key => $label)
                                <option value="{{ $key }}" @selected(old('temperature_preference', 'warm') === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="distance_preference" class="form-label">Let z Viedne</label>
                        <select name="distance_preference" id="distance_preference" class="form-select" required>
                            @foreach ($distancePreferences as $key => $label)
                                <option value="{{ $key }}" @selected(old('distance_preference', 'up_to_3') === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="form-label">Typ dovolenky</div>
                    <div class="row g-2">
                        @foreach ($destinationTypes as $type)
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-check choice-tile px-3 py-3 h-100">
                                    <input
                                        type="checkbox"
                                        name="destination_types[]"
                                        id="type-{{ $type->id }}"
                                        value="{{ $type->id }}"
                                        class="form-check-input ms-0 me-2"
                                        @checked(in_array($type->id, old('destination_types', [])))
                                    >
                                    <label for="type-{{ $type->id }}" class="form-check-label">{{ $type->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-4">Nájsť destinácie</button>
                </div>
            </form>
        </div>
    </div>
@endsection
