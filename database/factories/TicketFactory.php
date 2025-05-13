<?php

namespace Database\Factories;

use App\Models\EstadoTicket;
use App\Models\TipoTicket;
use App\Models\Persona;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'estado_ticket_id' => EstadoTicket::inRandomOrder()->first()->id ?? EstadoTicket::factory(),
            'tipo_ticket_id' => TipoTicket::inRandomOrder()->first()->id ?? TipoTicket::factory(),
            'personas_id' => Persona::inRandomOrder()->first()->id ?? Persona::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'titulo' => $this->faker->sentence(4),
            'descripcion' => $this->faker->paragraph(3),
            'prioridad' => $this->faker->numberBetween(1, 5),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}