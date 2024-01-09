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
        Schema::create('payables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->references('id')->on('vendors')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('purchase_id')->references('id')->on('purchases')->restrictOnDelete()->restrictOnUpdate();
            $table->string('invoice_number')->nullable()->index();
            $table->decimal('total_amount', 20);
            $table->decimal('vat');
            $table->decimal('total_vat', 20);
            $table->decimal('discount');
            $table->decimal('total_discount', 20);
            $table->decimal('grand_total', 20);
            $table->decimal('paid', 20);
            $table->decimal('remain', 20);
            $table->timestampTz('paid_at')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payables');
    }
};
