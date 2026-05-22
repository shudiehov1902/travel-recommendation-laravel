<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlyWeather extends Model
{
    protected $table = 'monthly_weather';

    protected $fillable = [
        'destination_id',
        'month',
        'avg_temp',
        'min_temp',
        'max_temp',
    ];

    protected function casts(): array
    {
        return [
            'month' => 'integer',
            'avg_temp' => 'decimal:1',
            'min_temp' => 'decimal:1',
            'max_temp' => 'decimal:1',
        ];
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }
}
