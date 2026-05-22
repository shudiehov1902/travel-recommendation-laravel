<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DestinationType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(Destination::class, 'destination_destination_type');
    }

    public function searches(): BelongsToMany
    {
        return $this->belongsToMany(Search::class, 'search_type');
    }
}
