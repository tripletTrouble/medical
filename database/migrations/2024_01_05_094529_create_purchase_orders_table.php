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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->nullable()->index();
            $table->foreignId('vendor_id')->references('id')->on('vendors')->restrictOnDelete()->restrictOnUpdate();
            $table->date('order_date')->index();
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->decimal('total_amount', 20)->nullable();
            $table->decimal('total_vat', 20)->nullable();
            $table->decimal('total_discount', 20)->nullable();
            $table->decimal('grand_total', 20)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
