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
        Schema::create('payment_plan_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_plan_id')->references('id')->on('payment_plans')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('payable_id')->references('id')->on('payables')->restrictOnDelete()->restrictOnUpdate();
            $table->decimal('amount', 20);
            $table->decimal('vat');
            $table->decimal('vat_amount', 20);
            $table->decimal('discount');
            $table->decimal('discount_amount', 20);
            $table->decimal('total_amount', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_plan_lines');
    }
};
