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
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id();
            $table->string('payment_plan_number')->nullable()->index();
            $table->foreignId('vendor_id')->references('id')->on('vendors')->restrictOnDelete()->restrictOnUpdate();
            $table->decimal('total_amount', 20);
            $table->decimal('total_vat', 20);
            $table->decimal('total_discount', 20);
            $table->decimal('grand_total', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_plans');
    }
};
