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

        try {
            // Renombrar clave foránea para estado_ticket_id
            $this->renameForeignKey(
                'tickets',
                'estado_ticket_id',
                'estado_ticket_id',
                'estados_tickets'
            );

            // Renombrar clave foránea para tipo_ticket_id
            $this->renameForeignKey(
                'tickets',
                'tipo_ticket_id',
                'tipo_ticket_id',
                'tipo_tickets'
            );
        } catch (\Exception $e) {
            Log::error('Error en migración: ' . $e->getMessage());
            throw $e;
        }
    }

    public function down()
    {
        if (!Schema::hasTable('tickets')) {
            return;
        }

        try {
            // Revertir clave foránea para estado_ticket_id
            $this->renameForeignKey(
                'tickets',
                'estado_ticket_id',
                'estado_ticket_id',
                'estados_tickets',
                true
            );

            // Revertir clave foránea para tipo_ticket_id
            $this->renameForeignKey(
                'tickets',
                'tipo_ticket_id',
                'tipo_ticket_id',
                'tipo_tickets',
                true
            );
        } catch (\Exception $e) {
            Log::error('Error al revertir migración: ' . $e->getMessage());
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

        if (!empty($foreignKeys)) {
            $constraintName = $foreignKeys[0]->CONSTRAINT_NAME;

            // Eliminar clave foránea existente
            Schema::table($tableName, function (Blueprint $table) use ($constraintName) {
                $table->dropForeign($constraintName); // Cambiado para usar string
            });
        }

        // Renombrar columna si es necesario
        if ($oldColumn !== $newColumn) {
            Schema::table($tableName, function (Blueprint $table) use ($oldColumn, $newColumn) {
                $table->renameColumn($oldColumn, $newColumn);
            });
        }

        // Crear nueva clave foránea si no es rollback
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