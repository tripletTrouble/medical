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
        Schema::create('recipe_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->references('id')->on('items')->restrictOnDelete()->restrictOnUpdate();
            $table->tinyInteger('frequency')->nullable();
            $table->tinyInteger('period')->nullable();
            $table->integer('amount')->nullable();
            $table->string('annotation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_order_items');
    }
};
