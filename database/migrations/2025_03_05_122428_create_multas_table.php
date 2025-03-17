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
        Schema::create('multas', function (Blueprint $table) {
            $table->id();
            $table->float('total');
            $table->unsignedBigInteger('multaPrestamo_id');
            $table->unsignedBigInteger('persona_id');
            $table->timestamps();

            $table->foreign('multaPrestamo_id')
            ->references('id')->on('multa_prestamo');

            $table->foreign('persona_id')
            ->references('id')->on('personas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multas');
    }
};
