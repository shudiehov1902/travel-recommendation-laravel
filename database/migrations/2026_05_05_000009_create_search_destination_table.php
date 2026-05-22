<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('search_destination', function (Blueprint $table) {
            $table->foreignId('search_id')->constrained()->cascadeOnDelete();
            $table->foreignId('destination_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('score')->default(0);
            $table->timestamps();

            $table->primary(['search_id', 'destination_id']);
            $table->index('score');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('search_destination');
    }
};
