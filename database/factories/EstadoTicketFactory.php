<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EstadoTicketFactory extends Factory
{
    private static $estadoIndex = 0;

    public function definition()
    {
        $estados = [
            'Pendiente',
            'En Análisis',
            'Priorizado',
            'En Desarrollo',
            'En Testing',
            'Aprobado',
            'Rechazado'
        ];

        // Garantiza que no se repitan los valores
        $nombreEstado = $estados[self::$estadoIndex % count($estados)];
        self::$estadoIndex++;

        return [
            'nombre_estado' => $nombreEstado,
            'color' => $this->faker->hexColor(),
            'orden' => $this->faker->numberBetween(1, 100),
            'activo' => $this->faker->boolean(90),
            'deleted_at' => $this->faker->optional(10)->dateTime()
        ];
    }
}