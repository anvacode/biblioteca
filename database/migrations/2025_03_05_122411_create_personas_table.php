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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('N_documento');
            $table->string('correo');
            $table->string('telefono');
            $table->unsignedBigInteger('tipoDocumento_id');

            $table->timestamps();

            $table->foreign('tipoDocumento_id')
            ->references('id')->on('tipo_documento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
