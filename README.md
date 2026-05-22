# Kam na dovolenku?

Laravel aplikacia pre predmet WEBTE2, zadanie c. 4. Pouzivatel vyplni preferencie dovolenky a aplikacia odporuci destinacie podla zhody s poziadavkami.

## Funkcie

- vyhladavanie destinacii podla mesiaca alebo datumu, poctu dni, typu dovolenky, teploty a dlzky letu z Viedne,
- zoradenie destinacii podla odporucacieho skore,
- vysvetlenie odporucania pri kazdej destinacii,
- detail destinacie s historickym pocasim, krajinou, vlajkou, menou, kurzom a aktualnou predpovedou,
- porovnanie dvoch destinacii,
- interaktivna mapa odporucanych destinacii a mapa v detaile destinacie cez Leaflet a OpenStreetMap,
- vlastna statistika navstevnosti bez Google Analytics,
- hashovanie IP adresy a user agenta namiesto ukladania IP adresy,
- grafy cez Chart.js,
- externy Weather API cez Open-Meteo,
- externy Currency API cez Frankfurter,
- cache pre externe API odpovede, aby sa pocasie a kurzy nestahovali pri kazdom nacitani.

## Technologia

- PHP 8.3+
- Laravel 13
- MariaDB / MySQL
- Blade
- Bootstrap 5 cez CDN
- Chart.js cez CDN
- Leaflet cez CDN

## Instalacia lokalne

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Potom otvorit:

```text
http://127.0.0.1:8000
```

## Priklad .env pre MariaDB

```env
APP_NAME="Kam na dovolenku"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://node82.webte.fei.stuba.sk
APP_TIMEZONE=Europe/Bratislava

APP_LOCALE=sk
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=sk_SK

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webte2
DB_USERNAME=xshudiehov
DB_PASSWORD=SEM_VLOZIT_HESLO

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

OPEN_METEO_FORECAST_URL=https://api.open-meteo.com/v1/forecast
FRANKFURTER_RATES_URL=https://api.frankfurter.dev/v2/rates
OPEN_METEO_CACHE_TTL=3600
FRANKFURTER_CACHE_TTL=3600
```

Na serveri treba po skopirovani `.env` spustit:

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

## Deploy na node82.webte.fei.stuba.sk

Odporucany adresar na serveri:

```text
/var/www/node82.webte.fei.stuba.sk
```

Document root musi smerovat do Laravel `public`:

```text
/var/www/node82.webte.fei.stuba.sk/webte2-z4/public
```

Priklad Nginx konfiguracie je v subore:

```text
deploy/nginx-node82.conf
```

## SQL dump

Export lokalnej databazy:

```bash
mysqldump -u USER -p DATABASE_NAME > dump.sql
```

Pre XAMPP lokalne:

```bash
/Applications/XAMPP/xamppfiles/bin/mysqldump -h 127.0.0.1 -P 3306 -u root webte2_z4 > dump.sql
```

Import na serveri:

```bash
mysql -u xshudiehov -p webte2 < dump.sql
```

Alternativa je nepouzivat dump a spustit na serveri:

```bash
php artisan migrate --seed --force
```

## Co nedavat do ZIP

- `vendor/`
- `node_modules/`
- `.env`
- cache subory v `bootstrap/cache/`
- lokalne logy v `storage/logs/`

## Co dat do ZIP

- `app/`
- `bootstrap/`
- `config/`
- `database/`
- `public/`
- `resources/`
- `routes/`
- `tests/`
- `composer.json`
- `composer.lock`
- `package.json` ak zostava v projekte
- `.env.example`
- `.env.node82.example`
- `README.md`
- `dump.sql`
- `deploy/nginx-node82.conf`

## Poznamky

Ak externy API nie je dostupny, aplikacia nespadne. Detail destinacie zobrazi historicke data z databazy a hlasku, ze aktualne data su docasne nedostupne.
