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
        Schema::create('detalles_solicitud', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materiales_id');
            $table->unsignedBigInteger('solicitudes_id');
            $table->timestamps();

            $table->foreign('materiales_id')
            ->references('id')->on('materiales');
            $table->foreign('solicitudes_id')
            ->references('id')->on('solicitudes');
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_solicitud');
    }
};
