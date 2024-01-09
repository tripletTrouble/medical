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
        Schema::create('margins', function (Blueprint $table) {
            $table->id();
            $table->string('type_model');
            $table->unsignedBigInteger('type_model_id')->nullable();
            $table->string('factor_model')->nullable();
            $table->unsignedBigInteger('factor_model_id')->nullable();
            $table->decimal('amount', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('margins');
    }
};
