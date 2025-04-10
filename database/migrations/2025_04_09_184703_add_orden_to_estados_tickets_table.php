<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Verificar si la columna ya existe antes de agregarla
        if (Schema::hasTable('estados_tickets') && !Schema::hasColumn('estados_tickets', 'orden')) {
            Schema::table('estados_tickets', function (Blueprint $table) {
                $table->integer('orden')->default(0)->after('nombre_estado');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('estados_tickets', 'orden')) {
            Schema::table('estados_tickets', function (Blueprint $table) {
                $table->dropColumn('orden');
            });
        }
    }
};