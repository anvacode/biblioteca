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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha_reserva');
            $table->string('estado');
            $table->unsignedBigInteger('personas_id_persona');
            $table->unsignedBigInteger('materiales_id_materiales');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('personas_id_persona')->references('id')->on('personas');
            $table->foreign('materiales_id_materiales')->references('id')->on('materiales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};