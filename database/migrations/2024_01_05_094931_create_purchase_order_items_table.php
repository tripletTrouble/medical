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
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->references('id')->on('purchase_orders')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('item_id')->references('id')->on('items')->restrictOnDelete()->restrictOnUpdate();
            $table->float('qty');
            $table->foreignId('item_measure_id')->references('id')->on('item_measures')->restrictOnDelete()->restrictOnUpdate();
            $table->decimal('price', 20)->nullable();
            $table->decimal('p, 20rice_amount');
            $table->decimal('vat', 20)->nullable();
            $table->decimal('vat_amount', 20)->nullable();
            $table->decimal('discount', 20)->nullable();
            $table->decimal('discount_amount', 20)->nullable();
            $table->decimal('sub_total', 20)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
