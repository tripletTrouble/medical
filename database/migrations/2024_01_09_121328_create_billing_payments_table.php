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
        Schema::create('billing_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billing_id')->references('id')->on('billings')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('payment_number')->nullable()->index();
            $table->decimal('total_amount', 20);
            $table->decimal('total_vat', 20);
            $table->decimal('total_discount', 20);
            $table->decimal('total_netto', 20);
            $table->decimal('total_paid');
            $table->decimal('remain', 20);
            $table->timestampTz('paid_at')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_payments');
    }
};
