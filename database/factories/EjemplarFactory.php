<?php

namespace Database\Factories;

use App\Models\Ejemplar;
use Illuminate\Database\Eloquent\Factories\Factory;

class EjemplarFactory extends Factory
{
    protected $model = Ejemplar::class;

    public function definition()
    {
        return [
            'codigo' => $this->faker->unique()->randomNumber(6),
            'estado' => $this->faker->randomElement(['disponible', 'prestado', 'reservado']),
            'materiales_id_materiales' => \App\Models\Material::factory(),
            'materiales_personas_id_persona' => \App\Models\Persona::factory(),
        ];
    }
}
