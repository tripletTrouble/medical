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
        Schema::create('item_stock_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_dimension_id')->references('id')->on('item_dimensions')->restrictOnDelete()->restrictOnUpdate();
            $table->string('transaction_model_type');
            $table->unsignedBigInteger('transaction_model_id');
            $table->decimal('amount', 20);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_ledgers');
    }
};
