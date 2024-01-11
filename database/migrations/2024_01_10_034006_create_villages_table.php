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
        Schema::dropIfExists('villages');

        Schema::create('villages', function (Blueprint $table) {
            $table->string('district_code', 6);
            $table->string('code', 10)->unique();
            $table->string('name', 75)->index('villages_name_index');
            $table->string('postal_code', 10);
            $table->timestamps();

            $table->foreign('district_code')->references('code')->on('districts')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villages');
    }
};
