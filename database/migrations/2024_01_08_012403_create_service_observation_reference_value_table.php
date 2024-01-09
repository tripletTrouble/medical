<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_reference_value', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->references('id')->on('services')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('reference_value_id')->references('id')->on('reference_values')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_observation_reference_value');
    }
};
