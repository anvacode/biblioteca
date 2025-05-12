<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoDocumento>
 */
class TipoDocumentoFactory extends Factory
{
    protected $model = \App\Models\TipoDocumento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(), // Nombre del tipo de documento
            'abreviatura' => strtoupper($this->faker->lexify('???')), // Abreviatura de 3 letras
        ];
    }
}
