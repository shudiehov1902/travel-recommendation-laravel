<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    protected $fillable = [
        'country_id',
        'name',
        'description',
        'image_url',
        'latitude',
        'longitude',
        'nearest_weather_city',
        'flight_hours_from_vienna',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'flight_hours_from_vienna' => 'decimal:2',
        ];
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(DestinationType::class, 'destination_destination_type');
    }

    public function monthlyWeather(): HasMany
    {
        return $this->hasMany(MonthlyWeather::class);
    }

    public function weatherForMonth(int $month): ?MonthlyWeather
    {
        return $this->monthlyWeather->firstWhere('month', $month);
    }
}
