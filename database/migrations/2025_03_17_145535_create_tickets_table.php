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
            
            // Relaciones (usa nombres consistentes)
            $table->unsignedBigInteger('estados_tickets'); // Nombre original
            $table->unsignedBigInteger('tipo_tickets'); // Nombre original
            $table->foreignId('user_id')->constrained();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('estados_tickets');
            $table->index('tipo_tickets');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};