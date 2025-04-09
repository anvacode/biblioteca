<?php

namespace Database\Seeders;

use App\Models\EstadoTicket;
use Illuminate\Database\Seeder;

class EstadosTicketsSeeder extends Seeder
{
    public function run()
    {
        $estados = [
            ['nombre_estado' => 'Abierto'],
            ['nombre_estado' => 'En progreso'],
            ['nombre_estado' => 'Pendiente'],
            ['nombre_estado' => 'Resuelto'],
            ['nombre_estado' => 'Cerrado'],
        ];

        foreach ($estados as $estado) {
            EstadoTicket::firstOrCreate($estado);
        }
    }
}