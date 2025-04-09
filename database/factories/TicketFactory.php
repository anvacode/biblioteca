<?php

namespace Database\Factories;

use App\Models\Persona;
use App\Models\EstadoTicket;
use App\Models\TipoTicket;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'personas_id' => Persona::factory(),
            'estados_tickets' => EstadoTicket::factory(),
            'tipo_tickets' => TipoTicket::factory(),
            
            // Campos adicionales comunes en tickets (si los añades después)
            'titulo' => $this->faker->sentence(4),
            'descripcion' => $this->faker->paragraph(3),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now')
        ];
    }

    // Métodos de estado rápido (opcional)
    public function abierto()
    {
        return $this->state(function (array $attributes) {
            return [
                'estados_tickets' => EstadoTicket::factory()->abierto()
            ];
        });
    }

    public function soporteTecnico()
    {
        return $this->state(function (array $attributes) {
            return [
                'tipo_tickets' => TipoTicket::factory()->soporteTecnico()
            ];
        });
    }

    // Método para tickets recientes
    public function reciente()
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => $this->faker->dateTimeBetween('-3 days', 'now')
            ];
        });
    }
}