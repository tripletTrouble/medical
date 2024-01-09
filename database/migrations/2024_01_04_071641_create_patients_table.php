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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('pob', 125)->nullable();
            $table->date('dob')->nullable();
            $table->string('identity_type', 20)->nullable();
            $table->string('identity_number', 50)->nullable()->unique();
            $table->string('guardian_name')->nullable();
            $table->json('details')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->fullText(['first_name', 'last_name', 'identity_number', 'guardian_name'], 'patient_fulltext_ix');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
