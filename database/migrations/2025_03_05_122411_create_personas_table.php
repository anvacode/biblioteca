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
            $table->string('n_documento')->unique();
            $table->string('correo')->unique();
            $table->string('telefono')->nullable();
            $table->unsignedBigInteger('tipoDocumento_id')->nullable(); // Relación con TipoDocumento
            $table->timestamps();

            // Llave foránea
            $table->foreign('tipoDocumento_id')->references('id')->on('tipo_documento')->onDelete('cascade');
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
