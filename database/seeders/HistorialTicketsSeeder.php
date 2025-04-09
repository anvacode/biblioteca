<?php

namespace Database\Seeders;

use App\Models\HistorialTicket;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class HistorialTicketsSeeder extends Seeder
{
    public function run()
    {
        // Crea 3 registros de historial para cada ticket
        Ticket::all()->each(function ($ticket) {
            HistorialTicket::factory()
                ->count(3)
                ->paraTicket($ticket)
                ->create();
        });
    }
}