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
        Schema::create('billing_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billing_id')->references('id')->on('billings')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('status_code');
            $table->string('status_name');
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
        Schema::dropIfExists('billing_statuses');
    }
};
