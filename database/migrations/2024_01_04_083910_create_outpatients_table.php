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
        Schema::create('outpatients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->references('id')->on('patients')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('polyclinic_id')->nullable()->references('id')->on('polyclinics')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('prectitioner_id')->nullable()->references('id')->on('practitioners')->nullOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('payment_type');
            $table->foreignId('insurance_id')->nullable()->references('id')->on('insurances')->nullOnDelete()->cascadeOnUpdate();
            $table->timestampTz('exited_at')->nullable();
            $table->timestampTz('entered_at')->nullable();
            $table->json('details')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outpatients');
    }
};
