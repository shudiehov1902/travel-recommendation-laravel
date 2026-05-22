<?php

namespace App\Services;

use App\Models\Visit;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;

class VisitService
{
    public function track(Request $request): Visit
    {
        $visitorHash = $this->visitorHash($request);
        $createdAt = now();

        $isUnique = ! Visit::query()
            ->where('visitor_hash', $visitorHash)
            ->where('created_at', '>=', $createdAt->copy()->subMinutes(60))
            ->exists();

        return Visit::create([
            'visitor_hash' => $visitorHash,
            'time_period' => $this->timePeriod($createdAt),
            'is_unique' => $isUnique,
        ]);
    }

    public function visitorHash(Request $request): string
    {
        return hash(
            'sha256',
            ($request->ip() ?? 'unknown-ip')
            . '|'
            . ($request->userAgent() ?? 'unknown-agent')
            . '|'
            . (string) config('app.key')
        );
    }

    public function timePeriod(CarbonInterface $time): string
    {
        $hour = (int) $time->format('G');

        return match (true) {
            $hour >= 6 && $hour < 15 => 'morning',
            $hour >= 15 && $hour < 21 => 'afternoon',
            $hour >= 21 => 'evening',
            default => 'night',
        };
    }
}
