<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{
    protected $model = \App\Models\Categoria::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->word(), // Nombre de la categoría
            'descripcion' => $this->faker->sentence(), // Descripción de la categoría
            'estado' => 'activo', // Valor predeterminado para el estado
            'registradoPor' => $this->faker->name(), // Generar un valor para registradoPor
        ];
    }
}