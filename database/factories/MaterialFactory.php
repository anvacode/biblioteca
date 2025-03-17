<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    protected $model = Material::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence,
            'isbn' => $this->faker->isbn13,
            'anyo' => $this->faker->year,
            'estante' => $this->faker->word,
            'estado' => $this->faker->randomElement(['disponible', 'prestado', 'reservado']),
            'registradoPor' => $this->faker->name,
            'fecha' => $this->faker->dateTime,
            'personas_id_persona' => \App\Models\Persona::factory(),
            'categorias_idcategorias' => \App\Models\Categoria::factory(),
            'editoriales_ideditoriales' => \App\Models\Editorial::factory(),
        ];
    }
}
