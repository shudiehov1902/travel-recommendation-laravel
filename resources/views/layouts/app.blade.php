<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        :root {
            --page-bg: #eef3f1;
            --surface: #ffffff;
            --surface-soft: #f7faf8;
            --ink: #1d2526;
            --muted: #657273;
            --line: #dbe4df;
            --brand: #0f766e;
            --brand-dark: #0b5f59;
            --brand-soft: #dff4ef;
            --coral: #d45d4c;
            --amber: #c4841d;
            --sky: #2d72b8;
            --shadow: 0 18px 50px rgba(18, 38, 41, .10);
        }

        body {
            min-height: 100vh;
            background:
                linear-gradient(180deg, rgba(9, 31, 35, .78) 0, rgba(9, 31, 35, .66) 288px, rgba(238, 243, 241, 0) 289px),
                url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1800&q=80') center top / cover no-repeat fixed,
                var(--page-bg);
            color: var(--ink);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            letter-spacing: 0;
        }

        .navbar {
            background: rgba(255, 255, 255, .92);
            border-bottom: 1px solid rgba(255, 255, 255, .45);
            box-shadow: 0 10px 32px rgba(10, 28, 31, .12);
            backdrop-filter: blur(14px);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--ink);
        }

        .navbar-brand::before {
            content: "";
            display: inline-block;
            width: .78rem;
            height: .78rem;
            margin-right: .45rem;
            border-radius: 50%;
            background: conic-gradient(from 190deg, var(--coral), var(--amber), var(--brand), var(--sky), var(--coral));
            vertical-align: -.03rem;
        }

        .nav-link {
            border-radius: 999px;
            color: #344446;
            font-weight: 600;
            padding-inline: .9rem !important;
        }

        .nav-link.active,
        .nav-link:hover {
            background: var(--brand-soft);
            color: var(--brand-dark);
        }

        .page-shell {
            max-width: 1160px;
        }

        .tool-panel,
        .result-card {
            background: rgba(255, 255, 255, .96);
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        .metric-box {
            background: linear-gradient(180deg, #fff, var(--surface-soft));
            border: 1px solid var(--line);
            border-radius: 8px;
        }

        .tool-panel {
            padding: 1.5rem;
        }

        .result-card {
            padding: 1.25rem;
            height: 100%;
            overflow: hidden;
        }

        .metric-box {
            padding: 1rem;
        }

        .muted {
            color: var(--muted);
        }

        .score-badge {
            background: var(--brand-soft);
            color: var(--brand-dark);
            border: 1px solid #b7e1da;
            border-radius: 999px;
            padding: .25rem .65rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .type-chip {
            display: inline-flex;
            align-items: center;
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: .25rem .65rem;
            margin: .15rem .2rem .15rem 0;
            background: #f8fbfa;
            font-size: .88rem;
            font-weight: 600;
            color: #334447;
        }

        .page-kicker {
            color: rgba(255, 255, 255, .78);
            font-size: .8rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .page-hero {
            color: #fff;
            padding: 2.35rem 0 1.4rem;
        }

        .page-hero h1 {
            max-width: 760px;
            font-size: clamp(2rem, 4vw, 4.4rem);
            font-weight: 800;
            line-height: .98;
            margin-bottom: 1rem;
        }

        .page-hero .lead {
            max-width: 620px;
            color: rgba(255, 255, 255, .84);
            font-size: 1.05rem;
        }

        .hero-facts {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: .75rem;
            max-width: 620px;
        }

        .hero-fact {
            border: 1px solid rgba(255, 255, 255, .28);
            border-radius: 8px;
            padding: .8rem;
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(10px);
        }

        .hero-fact strong {
            display: block;
            font-size: 1.3rem;
            line-height: 1.1;
        }

        .hero-fact span {
            display: block;
            color: rgba(255, 255, 255, .75);
            font-size: .82rem;
            margin-top: .2rem;
        }

        .content-lift {
            margin-top: .5rem;
        }

        .form-label,
        .section-title {
            color: #213032;
        }

        .form-control,
        .form-select {
            border-color: #cfdad6;
            border-radius: 8px;
            min-height: 2.8rem;
        }

        .form-control:focus,
        .form-select:focus,
        .form-check-input:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 .2rem rgba(15, 118, 110, .15);
        }

        .choice-tile {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 8px;
            transition: transform .16s ease, border-color .16s ease, box-shadow .16s ease;
        }

        .choice-tile:hover {
            transform: translateY(-1px);
            border-color: rgba(15, 118, 110, .45);
            box-shadow: 0 10px 24px rgba(18, 38, 41, .08);
        }

        .destination-photo {
            aspect-ratio: 16 / 10;
            margin: -1.25rem -1.25rem 1.1rem;
            overflow: hidden;
            background: #d9e6e3;
            border-bottom: 1px solid var(--line);
        }

        .destination-photo img,
        .comparison-thumb,
        .destination-cover-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .destination-photo img {
            transition: transform .35s ease;
        }

        .result-card:hover .destination-photo img {
            transform: scale(1.04);
        }

        .destination-cover {
            position: relative;
            min-height: 310px;
            padding: 2rem;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
            background:
                linear-gradient(90deg, rgba(8, 28, 31, .88), rgba(8, 28, 31, .44)),
                var(--destination-image, url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1800&q=80')) center / cover no-repeat;
        }

        .destination-cover > * {
            position: relative;
            z-index: 1;
        }

        .comparison-heading {
            min-width: 220px;
        }

        .comparison-thumb-wrap {
            width: 100%;
            aspect-ratio: 16 / 9;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: .65rem;
            background: #d9e6e3;
        }

        .weather-strip {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            border: 1px solid var(--line);
            border-radius: 8px;
            overflow: hidden;
            background: var(--surface-soft);
        }

        .weather-strip > div {
            padding: .65rem .75rem;
        }

        .weather-strip > div + div {
            border-left: 1px solid var(--line);
        }

        .weather-strip .value {
            display: block;
            font-size: 1.05rem;
            font-weight: 800;
            color: #243234;
        }

        .reason-list {
            padding-left: 1.1rem;
        }

        .reason-list li {
            margin-bottom: .28rem;
        }

        .detail-hero {
            color: #fff;
            padding: 2rem 0 1rem;
        }

        .detail-hero h1 {
            font-size: clamp(2.1rem, 5vw, 4.8rem);
            font-weight: 800;
            line-height: .96;
        }

        .plain-metric {
            padding: .15rem 0;
        }

        .plain-metric .value {
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .sticky-compare {
            position: sticky;
            bottom: 1rem;
            z-index: 2;
        }

        .btn-primary {
            --bs-btn-bg: var(--brand);
            --bs-btn-border-color: var(--brand);
            --bs-btn-hover-bg: var(--brand-dark);
            --bs-btn-hover-border-color: var(--brand-dark);
        }

        .btn-outline-primary {
            --bs-btn-color: var(--brand-dark);
            --bs-btn-border-color: rgba(15, 118, 110, .55);
            --bs-btn-hover-bg: var(--brand);
            --bs-btn-hover-border-color: var(--brand);
        }

        .table thead th {
            color: var(--muted);
            font-weight: 700;
            font-size: .9rem;
        }

        .section-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .flag {
            width: 34px;
            height: 22px;
            object-fit: cover;
            border: 1px solid var(--line);
        }

        canvas {
            max-height: 320px;
        }

        .destination-map {
            width: 100%;
            min-height: 380px;
            border: 1px solid var(--line);
            border-radius: 8px;
            overflow: hidden;
            background: #d9e6e3;
        }

        .destination-map.is-compact {
            min-height: 260px;
        }

        .map-popup-title {
            margin: 0 0 .15rem;
            font-size: 1rem;
            font-weight: 800;
        }

        .map-popup-meta {
            color: #4b5b5d;
            font-size: .86rem;
        }

        .compare-status {
            min-height: 1.2rem;
        }

        @media (max-width: 767.98px) {
            body {
                background-attachment: scroll;
            }

            .page-hero {
                padding-top: 1.6rem;
            }

            .page-hero h1,
            .detail-hero h1 {
                line-height: 1.04;
            }

            .hero-facts {
                grid-template-columns: 1fr;
            }

            .tool-panel,
            .result-card {
                padding: 1rem;
            }

            .destination-photo {
                margin: -1rem -1rem 1rem;
            }

            .destination-cover {
                min-height: 280px;
                padding: 1.25rem;
            }

            .sticky-compare {
                bottom: .5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container page-shell">
            <a class="navbar-brand" href="{{ route('home') }}">Kam na dovolenku?</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('home')]) href="{{ route('home') }}">Vyhľadávanie</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'active' => request()->routeIs('statistics.index')]) href="{{ route('statistics.index') }}">Štatistika</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container page-shell py-4 py-lg-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Skontrolujte formulár.</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
