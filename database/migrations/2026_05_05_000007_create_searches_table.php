<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('searches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedTinyInteger('month')->nullable();
            $table->unsignedSmallInteger('duration_days');
            $table->string('temperature_preference');
            $table->string('distance_preference');
            $table->timestamps();

            $table->index('month');
            $table->index('temperature_preference');
            $table->index('distance_preference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('searches');
    }
};
