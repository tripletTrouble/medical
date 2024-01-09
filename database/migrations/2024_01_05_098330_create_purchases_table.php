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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->references('id')->on('purchase_orders')->restrictOnDelete()->restrictOnUpdate();
            $table->string('purchase_number')->nullable()->index();
            $table->string('invoice_number')->nullable()->index();
            $table->foreignId('vendor_id')->references('id')->on('vendors')->restrictOnDelete()->restrictOnUpdate();
            $table->date('purchase_date')->index();
            $table->decimal('total_amount', 20)->nullable();
            $table->decimal('total_vat', 20)->nullable();
            $table->decimal('total_discount', 20)->nullable();
            $table->decimal('grand_total', 20);
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
