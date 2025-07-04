<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClasificacionFactory extends Factory
{
    protected $model = \App\Models\Clasificacion::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(),
            'estado' => 'activo', // Valor predeterminado para el estado
            'registradoPor' => $this->faker->name(), // Generar un valor para registradoPor
        ];
    }
}
