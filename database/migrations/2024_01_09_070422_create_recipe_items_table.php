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
        Schema::create('recipe_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id')->references('id')->on('recipes')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('item_id')->nullable()->references('id')->on('items')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('item_dimension_id')->nullable()->references('id')->on('item_dimensions')->restrictOnDelete()->restrictOnUpdate();
            $table->string('item_name')->nullable();
            $table->tinyInteger('frequency')->nullable();
            $table->tinyInteger('period')->nullable();
            $table->integer('amount')->nullable();
            $table->string('annotation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_items');
    }
};
