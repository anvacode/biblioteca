<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    protected $model = \App\Models\Material::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(),
            'isbn' => $this->faker->isbn13(),
            'anyo' => $this->faker->year(),
            'estado' => 'disponible',
            'registradoPor' => $this->faker->name(),
            'clasificaciones_id' => \App\Models\Clasificacion::factory(), // Relación con clasificaciones
            'categorias_id' => \App\Models\Categoria::factory(), // Relación con categorías
            'estantes_id' => \App\Models\Estante::factory(), // Relación con estantes
        ];
    }
}
