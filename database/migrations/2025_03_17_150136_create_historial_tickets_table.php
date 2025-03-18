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
        Schema::create('historial_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personas_id');
            $table->unsignedBigInteger('tickets_idtickets');
            $table->timestamp('fecha_cambio');
            $table->string('comentario');
            $table->string('persona_responsable');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('personas_id')->references('id')->on('personas');
            $table->foreign('tickets_idtickets')->references('id')->on('tickets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_tickets');
    }
};