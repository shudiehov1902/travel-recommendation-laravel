<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Search extends Model
{
    protected $fillable = [
        'destination_id',
        'month',
        'duration_days',
        'temperature_preference',
        'distance_preference',
    ];

    protected function casts(): array
    {
        return [
            'month' => 'integer',
            'duration_days' => 'integer',
        ];
    }

    public function selectedDestination(): BelongsTo
    {
        return $this->belongsTo(Destination::class, 'destination_id');
    }

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(DestinationType::class, 'search_type');
    }

    public function recommendedDestinations(): BelongsToMany
    {
        return $this->belongsToMany(Destination::class, 'search_destination')
            ->withPivot('score')
            ->withTimestamps();
    }
}
