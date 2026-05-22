<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->char('visitor_hash', 64);
            $table->enum('time_period', ['morning', 'afternoon', 'evening', 'night']);
            $table->boolean('is_unique')->default(false);
            $table->timestamps();

            $table->index('visitor_hash');
            $table->index('time_period');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
