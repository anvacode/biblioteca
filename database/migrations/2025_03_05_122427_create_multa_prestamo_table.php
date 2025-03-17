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
        Schema::create('multa_prestamo', function (Blueprint $table) {
            $table->id();
            $table->Datetime('fecha_multa');
            $table->unsignedBigInteger('multaPrestamo_id');
            $table->float('valor');
            $table->float('multa');
            
            $table->timestamps();
            $table->foreign('multaPrestamo_id')
            ->references('id')->on('multa_prestamo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multa_prestamo');
    }
};
