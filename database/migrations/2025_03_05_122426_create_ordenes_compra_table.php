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
        Schema::create('ordenes_compra', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitudes_id');
            $table->string('fechaCompra');
            $table->string('totalPagado');

           
            $table->timestamps();
            
            $table->foreign('solicitudes_id')
            ->references('id')->on('solicitudes');

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_compra');
    }
};
