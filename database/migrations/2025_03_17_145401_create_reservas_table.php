<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Definición de la migración para la tabla 'reservas'
return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     * Este método se llama cuando se ejecuta el comando `php artisan migrate`.
     */
    public function up(): void
    {
        // Crea la tabla 'reservas'
        Schema::create('reservas', function (Blueprint $table) {
            $table->id(); // Columna de ID autoincremental
            $table->timestamp('fecha_reserva'); // Columna para almacenar la fecha y hora de la reserva
            $table->string('estado'); // Columna para almacenar el estado de la reserva (por ejemplo, "pendiente", "confirmada", etc.)
            $table->unsignedBigInteger('personas_id'); // Columna para la clave foránea que referencia a la tabla 'personas'
            $table->unsignedBigInteger('materiales_id'); // Columna para la clave foránea que referencia a la tabla 'materiales'
            $table->timestamps(); // Columnas 'created_at' y 'updated_at' para el manejo de timestamps

            // Definición de claves foráneas
            $table->foreign('personas_id')->references('id')->on('personas'); // Clave foránea que referencia a la tabla 'personas'
            $table->foreign('materiales_id')->references('id')->on('materiales'); // Clave foránea que referencia a la tabla 'materiales'
        });
    }

    /**
     * Revierte las migraciones.
     * Este método se llama cuando se ejecuta el comando `php artisan migrate:rollback`.
     */
    public function down(): void
    {
        // Elimina la tabla 'reservas' si existe
        Schema::dropIfExists('reservas');
    }
};