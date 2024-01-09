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
        Schema::create('receivables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billing_id')->nullable()->references('id')->on('billings')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('payment_id')->nullable()->references('id')->on('billing_payments')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('insurance_id')->nullable()->references('id')->on('insurances')->restrictOnDelete()->restrictOnUpdate();
            $table->decimal('total_amount', 20);
            $table->decimal('total_vat', 20);
            $table->decimal('total_discount', 20);
            $table->decimal('total_netto', 20);
            $table->decimal('paid', 20);
            $table->decimal('remain', 20);
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receivables');
    }
};
