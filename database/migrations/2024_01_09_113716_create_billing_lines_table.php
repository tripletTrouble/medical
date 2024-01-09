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
        Schema::create('service_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billing_id')->references('id')->on('billings')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('service_order_id')->nullable()->references('id')->on('service_orders')->restrictOnDelete()->restrictOnUpdate();
            $table->decimal('amount', 20);
            $table->decimal('vat');
            $table->decimal('vat_amount', 20);
            $table->decimal('discount');
            $table->decimal('discount_amount', 20);
            $table->decimal('total_amount', 20);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_lines');
    }
};
