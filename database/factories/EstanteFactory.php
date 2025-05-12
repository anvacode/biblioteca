<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EstanteFactory extends Factory
{
    protected $model = \App\Models\Estante::class;

    public function definition()
    {
        return [
            'section' => $this->faker->word(), // Generar una sección aleatoria
            'shelf_number' => $this->faker->numberBetween(1, 100), // Generar un número de estante aleatorio
        ];
    }
}