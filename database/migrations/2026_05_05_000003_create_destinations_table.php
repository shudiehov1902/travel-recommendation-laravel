<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('nearest_weather_city');
            $table->decimal('flight_hours_from_vienna', 4, 2);
            $table->timestamps();

            $table->unique(['country_id', 'name']);
            $table->index('flight_hours_from_vienna');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
