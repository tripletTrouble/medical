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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->string('billingable_model')->index();
            $table->unsignedBigInteger('billingable_id')->index();
            $table->string('billing_number');
            $table->decimal('total_amount', 20);
            $table->decimal('total_vat', 20);
            $table->decimal('total_discount', 20);
            $table->decimal('grand_total', 20);
            $table->tinyInteger('status');
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
