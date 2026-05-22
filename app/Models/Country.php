<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = [
        'name',
        'iso_code',
        'capital',
        'currency_code',
        'currency_name',
    ];

    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class);
    }
}
