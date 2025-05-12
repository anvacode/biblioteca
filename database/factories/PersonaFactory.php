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
            'nombre' => $this->faker->name(),
            'n_documento' => $this->faker->unique()->numerify('########'),
            'correo' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'tipoDocumento_id' => \App\Models\TipoDocumento::factory(), // Relación con TipoDocumento
        ];
    }
}