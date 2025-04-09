<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketsSeeder extends Seeder
{
    public function run()
    {
        // Crea 50 tickets con relaciones automáticas
        Ticket::factory()->count(50)->create();

        // Crea 10 tickets específicos en estado abierto
        Ticket::factory()
            ->count(10)
            ->abierto()
            ->create();
    }
}