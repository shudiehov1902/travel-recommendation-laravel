<?php

namespace App\Http\Middleware;

use App\Services\VisitService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TrackVisit
{
    public function __construct(private readonly VisitService $visitService)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        try {
            $this->visitService->track($request);
        } catch (Throwable $exception) {
            report($exception);
        }

        return $next($request);
    }
}
