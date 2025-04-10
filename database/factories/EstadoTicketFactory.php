<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EstadoTicketFactory extends Factory
{
    public function definition()
    {
        return [
            'nombre_estado' => $this->faker->unique()->randomElement([
                'Pendiente',
                'En Análisis',
                'Priorizado',
                'En Desarrollo',
                'En Testing',
                'Aprobado',
                'Rechazado'
            ]),
            'color' => $this->faker->hexColor(),
            'orden' => $this->faker->unique()->numberBetween(1, 10),
            'activo' => $this->faker->boolean(90), // 90% de probabilidad de estar activo
            'deleted_at' => $this->faker->optional(10)->dateTime() // 10% de probabilidad de estar "eliminado"
        ];
    }
}