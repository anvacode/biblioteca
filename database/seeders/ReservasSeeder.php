<?php

namespace Database\Seeders;

use App\Models\Reserva;
use Illuminate\Database\Seeder;

class ReservasSeeder extends Seeder
{
    public function run()
    {
        // Crea 30 reservas con relaciones automáticas
        Reserva::factory()
            ->count(30)
            ->create();

        // Crea 5 reservas confirmadas con persona específica (opcional)
        Reserva::factory()
            ->count(5)
            ->state([
                'estado' => 'confirmada',
                'personas_id' => \App\Models\Persona::first()->id,
            ])
            ->create();
    }
}