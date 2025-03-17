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
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('personas_id');
            $table->unsignedBigInteger('tipos_mantenimientos_id');
            $table->unsignedBigInteger('estados_id');
            $table->string('descripcion')->nullable();
            $table->timestamps();
            $table->foreign('personas_id')->references('id')->on('personas');
            $table->foreign('tipos_mantenimientos_id')->references('id')->on('tipos_mantenimientos');
            $table->foreign('estados_id')->references('id')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
