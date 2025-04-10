<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoTicket;

class TiposTicketsSeeder extends Seeder
{
    public function run()
    {
        // Crear tipos específicos primero
        TipoTicket::factory()->soporteTecnico()->create();
        TipoTicket::factory()->incidenteSeguridad()->create();
        TipoTicket::factory()->prestamoMaterial()->create();
        
        // Crear tipos aleatorios adicionales
        TipoTicket::factory()->count(7)->create();
    }
}