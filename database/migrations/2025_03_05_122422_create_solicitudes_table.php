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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proveedores_id');
            $table->unsignedBigInteger('persona_id');
            $table->string('estado');
            $table->string('fechaSolicitud');
            $table->timestamps();

            $table->foreign('proveedores_id')
            ->references('id')->on('proveedores');
            $table->foreign('persona_id')
            ->references('id')->on('personas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
