<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            
            // Columnas básicas
            $table->string('titulo');
            $table->text('descripcion');
            $table->integer('prioridad')->default(3); // 1-5
            
            // Relaciones (ajustadas para seguir las convenciones)
            $table->unsignedBigInteger('estado_ticket_id');
            $table->foreign('estado_ticket_id')->references('id')->on('estados_tickets')->onDelete('cascade');

            $table->unsignedBigInteger('tipo_ticket_id');
            $table->foreign('tipo_ticket_id')->references('id')->on('tipo_tickets')->onDelete('cascade');

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con usuarios
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};