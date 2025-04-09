<?php

namespace Database\Factories;

use App\Models\EstadoTicket;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstadoTicketFactory extends Factory
{
    protected $model = EstadoTicket::class;

    public function definition()
    {
        // Estados comunes para tickets 
        $estados = [
            'Abierto',
            'En progreso',
            'Pendiente',
            'Resuelto',
            'Cerrado',
            'Rechazado'
        ];

        return [
            'nombre_estado' => $this->faker->unique()->randomElement($estados),
        ];
    }

    // Métodos de estado rápido 
    public function abierto()
    {
        return $this->state(function (array $attributes) {
            return [
                'nombre_estado' => 'Abierto',
            ];
        });
    }

    public function resuelto()
    {
        return $this->state(function (array $attributes) {
            return [
                'nombre_estado' => 'Resuelto',
            ];
        });
    }
}