<?php

namespace Database\Factories;

use App\Models\Persona;
use App\Models\Material;
use App\Models\Reserva;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    public function definition()
    {
        // Estados posibles para la reserva
        $estados = ['pendiente', 'confirmada', 'cancelada', 'completada'];

        return [
            'fecha_reserva' => $this->faker->dateTimeBetween('now', '+1 month'), // Fecha aleatoria en el próximo mes
            'estado' => $this->faker->randomElement($estados),
            'personas_id' => Persona::factory(), // Relación con Persona 
            'materiales_id' => Material::factory(), // Relación con Material 
        ];
    }

    // Métodos adicionales para estados específicos (opcional)
    public function pendiente()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado' => 'pendiente',
            ];
        });
    }

    public function confirmada()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado' => 'confirmada',
            ];
        });
    }
}