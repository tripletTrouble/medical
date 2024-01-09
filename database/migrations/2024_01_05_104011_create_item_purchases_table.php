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
        Schema::create('item_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_dimension_id')->references('id')->on('item_dimensions')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('purchase_id')->nullable()->references('id')->on('purchases')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('amount', 20);
            $table->decimal('used', 20);
            $table->foreignId('item_measure_id')->references('id')->on('item_measures')->restrictOnDelete()->restrictOnUpdate();
            $table->decimal('unit_price', 20);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_purchases');
    }
};
