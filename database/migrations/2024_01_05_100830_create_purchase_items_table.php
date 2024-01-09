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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->references('id')->on('purchases')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('item_id')->references('id')->on('items')->restrictOnDelete()->restrictOnUpdate();
            $table->float('qty');
            $table->foreignId('item_measure_id')->references('id')->on('item_measures')->restrictOnDelete()->restrictOnUpdate();
            $table->decimal('price', 20);
            $table->decimal('price_amount', 20);
            $table->decimal('vat', 20);
            $table->decimal('vat_amount', 20);
            $table->decimal('discount', 20);
            $table->decimal('discount_amount', 20);
            $table->decimal('subtotal', 20);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
