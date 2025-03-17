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
        Schema::create('estantes', function (Blueprint $table) {
            $table->id();
            $table->string('section'); // Ejemplo: "Ciencias", "Historia"
            $table->integer('shelf_number'); // Número del estante
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estantes');
    }
};
