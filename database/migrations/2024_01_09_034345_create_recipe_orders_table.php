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
        Schema::create('recipe_orders', function (Blueprint $table) {
            $table->id();
            $table->string('recipable_model')->index();
            $table->unsignedBigInteger('recipable_id')->index();
            $table->string('order_number')->nullable()->index();
            $table->boolean('is_concoction')->nullable();
            $table->foreignId('requester_id')->references('id')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('user_id')->references('id')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->timestampTz('request_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_orders');
    }
};
