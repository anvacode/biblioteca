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
        Schema::create('materiales_autores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('autores_id');
            $table->unsignedBigInteger('materiales_id');
            $table->string('nombre');
            $table->timestamps();
            $table->foreign('autores_id')->references('id')->on('autores');
            $table->foreign('materiales_id')->references('id')->on('materiales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiales_autores');
    }
};
