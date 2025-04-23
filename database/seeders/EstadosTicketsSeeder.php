<?php

namespace Database\Seeders;

use App\Models\EstadoTicket;
use Illuminate\Database\Seeder;

class EstadosTicketsSeeder extends Seeder
{
    public function run()
    {
        // 1. Estados base (fijos)
        $estadosBase = [
            [
                'nombre_estado' => 'Nuevo',
                'color' => '#3490dc', // Azul
                'orden' => 1,
                'activo' => true
            ],
            [
                'nombre_estado' => 'En Progreso',
                'color' => '#f6993f', // Naranja
                'orden' => 2,
                'activo' => true
            ],
            [
                'nombre_estado' => 'Resuelto',
                'color' => '#38c172', // Verde
                'orden' => 3,
                'activo' => true
            ],
            [
                'nombre_estado' => 'Cerrado',
                'color' => '#6c757d', // Gris
                'orden' => 4,
                'activo' => true
            ],
            [
                'nombre_estado' => 'Cancelado',
                'color' => '#e3342f', // Rojo
                'orden' => 5,
                'activo' => false 
            ]
        ];

        foreach ($estadosBase as $estado) {
            EstadoTicket::firstOrCreate(
                ['nombre_estado' => $estado['nombre_estado']],
                $estado
            );
        }

        // 2. Estados aleatorios 
        if (app()->environment('local')) {
            EstadoTicket::factory()
                ->count(3) 
                ->create();
        }
    }
}