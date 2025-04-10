<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historial_tickets', function (Blueprint $table) {
            $table->id();
            
            // Relación con tipo_tickets (según tu migración)
            $table->unsignedBigInteger('tipo_ticket_id');
            $table->foreign('tipo_ticket_id')
                  ->references('id')
                  ->on('tipo_tickets')
                  ->onDelete('cascade');
            
            // Campos del historial
            $table->string('accion', 100);
            $table->text('comentario')->nullable();
            $table->json('detalles')->nullable();
            
            // Relación con users (asegúrate que existe)
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historial_tickets');
    }
};