<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('search_type', function (Blueprint $table) {
            $table->foreignId('search_id')->constrained()->cascadeOnDelete();
            $table->foreignId('destination_type_id')->constrained()->cascadeOnDelete();

            $table->primary(['search_id', 'destination_type_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('search_type');
    }
};
