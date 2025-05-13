<?php

namespace Database\Seeders;

use App\Models\EstadoTicket;
use Illuminate\Database\Seeder;

class EstadosTicketsSeeder extends Seeder
{
    public function run()
    {
        $estados = [
            ['nombre_estado' => 'Pendiente', 'color' => '#ffcc00', 'orden' => 1, 'activo' => true],
            ['nombre_estado' => 'En Análisis', 'color' => '#ff9900', 'orden' => 2, 'activo' => true],
            ['nombre_estado' => 'Priorizado', 'color' => '#ff6600', 'orden' => 3, 'activo' => true],
            ['nombre_estado' => 'En Desarrollo', 'color' => '#ff3300', 'orden' => 4, 'activo' => true],
            ['nombre_estado' => 'En Testing', 'color' => '#ff0000', 'orden' => 5, 'activo' => true],
            ['nombre_estado' => 'Aprobado', 'color' => '#00cc00', 'orden' => 6, 'activo' => true],
            ['nombre_estado' => 'Rechazado', 'color' => '#cc0000', 'orden' => 7, 'activo' => true],
        ];

        foreach ($estados as $estado) {
            EstadoTicket::updateOrCreate(
                ['nombre_estado' => $estado['nombre_estado']], // Condición para buscar duplicados
                $estado // Datos a insertar o actualizar
            );
        }
    }
}