<?php

namespace Database\Factories;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonaFactory extends Factory
{
    protected $model = Persona::class;

    public function definition()
    {
        return [
            'nombre_persona' => $this->faker->name,
            'n_documento' => $this->faker->unique()->randomNumber(8),
            'telefono' => $this->faker->phoneNumber,
            'correo' => $this->faker->unique()->safeEmail,
        ];
    }
}
