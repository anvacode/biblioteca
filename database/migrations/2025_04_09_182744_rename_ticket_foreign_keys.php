<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tickets')) {
            Log::info('Tabla tickets no existe, omitiendo migración');
            return;
        }

        // Eliminamos DB::transaction y manejamos manualmente
        try {
            // 1. Para estados_tickets
            $this->renameForeignKey(
                'tickets',
                'estados_tickets',
                'estado_ticket_id',
                'estados_tickets'
            );

            // 2. Para tipo_tickets
            $this->renameForeignKey(
                'tickets',
                'tipo_tickets',
                'tipo_ticket_id',
                'tipo_tickets'
            );
        } catch (\Exception $e) {
            Log::error('Error en migración: '.$e->getMessage());
            throw $e;
        }
    }

    public function down()
    {
        if (!Schema::hasTable('tickets')) {
            return;
        }

        try {
            // Revertir para estado_ticket_id
            $this->renameForeignKey(
                'tickets',
                'estado_ticket_id',
                'estados_tickets',
                'estados_tickets',
                true
            );

            // Revertir para tipo_ticket_id
            $this->renameForeignKey(
                'tickets',
                'tipo_ticket_id',
                'tipo_tickets',
                'tipo_tickets',
                true
            );
        } catch (\Exception $e) {
            Log::error('Error al revertir migración: '.$e->getMessage());
            throw $e;
        }
    }

    protected function renameForeignKey(
        string $tableName,
        string $oldColumn,
        string $newColumn,
        string $refTable,
        bool $isRollback = false
    ): void {
        if (!Schema::hasColumn($tableName, $oldColumn)) {
            return;
        }

        $schemaName = DB::getDatabaseName();
        $fkQuery = "SELECT CONSTRAINT_NAME 
                   FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                   WHERE TABLE_SCHEMA = ? 
                   AND TABLE_NAME = ? 
                   AND COLUMN_NAME = ? 
                   AND REFERENCED_TABLE_NAME IS NOT NULL";

        $foreignKeys = DB::select($fkQuery, [
            $schemaName,
            $tableName,
            $oldColumn
        ]);

        // Ejecutar cada operación por separado sin transacción
        if (!empty($foreignKeys)) {
            $constraintName = $foreignKeys[0]->CONSTRAINT_NAME;
            Schema::table($tableName, function (Blueprint $table) use ($constraintName) {
                $table->dropForeign([$constraintName]);
            });
        }

        Schema::table($tableName, function (Blueprint $table) use ($oldColumn, $newColumn) {
            $table->renameColumn($oldColumn, $newColumn);
        });

        if (!$isRollback) {
            Schema::table($tableName, function (Blueprint $table) use ($newColumn, $refTable) {
                $table->foreign($newColumn)
                    ->references('id')
                    ->on($refTable)
                    ->onDelete('restrict');
            });
        }
    }
};