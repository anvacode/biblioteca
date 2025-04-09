<?php

namespace Database\Factories;

use App\Models\Persona;
use App\Models\Ticket;
use App\Models\HistorialTicket;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistorialTicketFactory extends Factory
{
    protected $model = HistorialTicket::class;

    public function definition()
    {
        return [
            'personas_id' => Persona::factory(),
            'tickets_idtickets' => Ticket::factory(),
            'fecha_cambio' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'comentario' => $this->faker->paragraph(2),
            'persona_responsable' => $this->faker->name(),
        ];
    }

    // Métodos de conveniencia
    public function reciente()
    {
        return $this->state(function (array $attributes) {
            return [
                'fecha_cambio' => $this->faker->dateTimeBetween('-3 days', 'now')
            ];
        });
    }

    public function conComentarioLargo()
    {
        return $this->state(function (array $attributes) {
            return [
                'comentario' => $this->faker->paragraph(5)
            ];
        });
    }

    // Método para usar con tickets específicos
    public function paraTicket(Ticket $ticket)
    {
        return $this->state(function (array $attributes) use ($ticket) {
            return [
                'tickets_idtickets' => $ticket->id,
                'personas_id' => $ticket->personas_id // Opcional: mantener misma persona
            ];
        });
    }
}