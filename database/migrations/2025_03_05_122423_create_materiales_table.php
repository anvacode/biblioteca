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
        Schema::create('materiales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clasificaciones_id');
            $table->unsignedBigInteger('categorias_id');
            $table->unsignedBigInteger('estantes_id');
            $table->string('titulo');
            $table->string('isbn');
            $table->string('anyo');
            $table->string('estado');
            $table->string('registradoPor');
            $table->timestamps();
            $table->foreign('categorias_id')->references('id')->on('categorias');
            $table->foreign('clasificaciones_id')->references('id')->on('clasificaciones');
            $table->foreign('estantes_id')->references('id')->on('estantes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiales');
    }
};
