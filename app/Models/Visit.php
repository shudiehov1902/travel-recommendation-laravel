<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'visitor_hash',
        'time_period',
        'is_unique',
    ];

    protected function casts(): array
    {
        return [
            'is_unique' => 'boolean',
        ];
    }
}
