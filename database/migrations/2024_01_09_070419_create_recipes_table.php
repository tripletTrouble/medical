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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_order_id')->nullable()->references('id')->on('recipe_orders')->restrictOnDelete()->restrictOnUpdate();
            $table->boolean('is_concoction')->nullable();
            $table->foreignId('patient_id')->nullable()->references('id')->on('patients')->restrictOnDelete()->restrictOnUpdate();
            $table->string('recipe_number')->nullable()->index();
            $table->timestampTz('processed_at')->nullable();
            $table->timestampTz('given_at')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
