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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->Datetime('fecha_prestamo');
            $table->String('estado');
            $table->unsignedBigInteger('persona_id');
            $table->unsignedBigInteger('material_id');
            $table->Datetime('fecha_devolucion');
            $table->Datetime('fecha_entrega');
            $table->INTEGER('dias_retraso');
            $table->timestamps();

            $table->foreign('persona_id')
            ->references('id')->on('personas');

            $table->foreign('material_id')
            ->references('id')->on('materiales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
