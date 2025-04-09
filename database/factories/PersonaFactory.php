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
            'total_multas' => $this->faker->randomFloat(2, 0, 1000),
            'tipo_documento_id' => \App\Models\TipoDocumento::factory(),
            'mantenimiento_id' => null, 
            'inventario_id' => null, 
        ];
    }
}