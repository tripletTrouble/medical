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
        Schema::create('practitioners', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('identity_number')->unique();
            $table->tinyInteger('registration_type')->nullable();
            $table->string('registration_number')->nullable();
            $table->json('details')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->fullText(['first_name', 'last_name', 'identity_number'], 'practitioner_fulltext_ix');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practitioners');
    }
};
