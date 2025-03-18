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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personas_id');
            $table->unsignedBigInteger('estados_tickets');
            $table->unsignedBigInteger('tipo_tickets');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('personas_id')->references('id')->on('personas');
            $table->foreign('estados_tickets')->references('id')->on('estados_tickets');
            $table->foreign('tipo_tickets')->references('id')->on('tipo_tickets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};