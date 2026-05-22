# Travel Recommendation Laravel

Laravel application for WEBTE2. The user enters travel preferences and the app recommends destinations based on weather, month, vacation type, flight duration, and destination metadata.

## Live Project

- Live demo: [https://node82.webte.fei.stuba.sk/webte_z4/](https://node82.webte.fei.stuba.sk/webte_z4/)
- GitHub repository: [https://github.com/shudiehov1902/travel-recommendation-laravel](https://github.com/shudiehov1902/travel-recommendation-laravel)

The deployment runs on a temporary university server. If the link is unavailable when you read this, the server may already have been turned off, reset, or reassigned.

## Main Features

- destination recommendation by month or date range
- filters for vacation type, preferred temperature, trip length, and flight duration from Vienna
- ranking by recommendation score
- human-readable explanation for each recommendation
- destination detail with historical weather, country, flag, currency, exchange rate, and current forecast
- comparison page for two destinations
- interactive maps with Leaflet and OpenStreetMap
- custom visit statistics without Google Analytics
- hashed IP address and user agent instead of raw IP storage
- charts with Chart.js
- Open-Meteo forecast integration
- Frankfurter currency-rate integration
- database-backed cache for external API responses

## Technology Stack

- PHP 8.3+
- Laravel 13
- MariaDB or MySQL
- Blade templates
- Bootstrap 5 through CDN
- Leaflet through CDN
- Chart.js through CDN
- Open-Meteo API
- Frankfurter API

## Project Structure

```text
app/
  Http/Controllers/       Request handling
  Http/Middleware/        Visit tracking
  Models/                 Eloquent models
  Services/               Recommendation, visit, weather, currency logic
database/
  migrations/             Database schema
  seeders/                Country, destination, weather seed data
deploy/
  nginx-node82.conf       Example Nginx deployment config
resources/
  views/                  Blade pages
routes/
  web.php                 Web routes
tests/
  Feature/                Feature tests
dump.sql                  Database export
```

## Local Setup

1. Install PHP dependencies:

```bash
composer install
```

2. Create the environment file:

```bash
cp .env.example .env
php artisan key:generate
```

3. Configure database access in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webte2_z4
DB_USERNAME=root
DB_PASSWORD=
```

4. Run migrations and seeders:

```bash
php artisan migrate --seed
```

5. Start the local server:

```bash
php artisan serve
```

6. Open:

```text
http://127.0.0.1:8000
```

## Environment Variables

Useful external API settings:

```env
OPEN_METEO_FORECAST_URL=https://api.open-meteo.com/v1/forecast
FRANKFURTER_RATES_URL=https://api.frankfurter.dev/v2/rates
OPEN_METEO_CACHE_TTL=3600
FRANKFURTER_CACHE_TTL=3600
```

Production should use:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://node82.webte.fei.stuba.sk/webte_z4
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## Deployment Notes

The deployed course URL is:

```text
https://node82.webte.fei.stuba.sk/webte_z4/
```

For Nginx, the document root must point to Laravel's `public` directory. The example config is stored in:

```text
deploy/nginx-node82.conf
```

Typical production commands after copying `.env`:

```bash
php artisan key:generate
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan migrate --seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Database

The project can be initialized in two ways:

1. Run migrations and seeders:

```bash
php artisan migrate --seed --force
```

2. Import the included SQL dump:

```bash
mysql -u USER -p DATABASE_NAME < dump.sql
```

## What Is Not Committed

The repository intentionally excludes generated or machine-local files:

- `vendor/`
- `node_modules/`
- `.env`
- Laravel cache files in `bootstrap/cache/`
- local logs in `storage/logs/`
- built frontend assets in `public/build/`

## Verification Checklist

- home page opens
- recommendation form returns ranked destinations
- destination detail loads weather and currency sections
- comparison page works for two destinations
- maps render with correct markers
- statistics page shows charts
- external API failure is handled without crashing the app
