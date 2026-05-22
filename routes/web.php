<?php

use App\Http\Controllers\CompareController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StatisticsController;
use App\Http\Middleware\TrackVisit;
use Illuminate\Support\Facades\Route;

Route::middleware(TrackVisit::class)->group(function (): void {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/destinations/{destination}', [DestinationController::class, 'show'])->name('destinations.show');
    Route::post('/compare', [CompareController::class, 'compare'])->name('compare');
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
});
