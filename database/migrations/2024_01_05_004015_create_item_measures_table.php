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
        Schema::create('item_measures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->references('id')->on('items')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('measure');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->decimal('scale')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_measures');
    }
};
