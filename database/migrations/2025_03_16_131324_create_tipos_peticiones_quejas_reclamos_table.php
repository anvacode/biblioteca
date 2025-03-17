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
        Schema::create('tipos_peticiones_quejas_reclamos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->unsignedBigInteger('peticion_queja_reclamo_id');
            $table->timestamps();

            $table->foreign('peticion_queja_reclamo_id', 'fk_tipos_pqrs_pqrs')
            ->references('id')->on('peticiones_quejas_reclamos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_peticiones_quejas_reclamos');
    }
};
