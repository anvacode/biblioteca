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
        Schema::rename('ordenes_compra', 'orden_compras');
        Schema::rename('detalles_solicitud', 'detalle_solicitudes');
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('orden_compras', 'ordenes_compra');
        Schema::rename('detalle_solicitudes', 'detalles_solicitud');
        //
    }
};
