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
        Schema::create('item_dimensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->references('id')->on('items')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('warehouse_id')->references('id')->on('warehouses')->restrictOnDelete()->restrictOnUpdate();
            $table->string('batch_number')->nullable();
            $table->date('expired_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_dimensions');
    }
};
