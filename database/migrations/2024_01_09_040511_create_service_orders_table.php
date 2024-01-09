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
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('billingable_model')->index();
            $table->unsignedBigInteger('billingable_id')->index();
            $table->string('order_number')->nullable()->index();
            $table->foreignId('referral_id')->references('id')->on('polyclinics')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('service_id')->references('id')->on('services')->restrictOnDelete()->restrictOnUpdate();
            $table->integer('qty')->nullable();
            $table->string('annotation');
            $table->foreignId('requester_id')->references('id')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
