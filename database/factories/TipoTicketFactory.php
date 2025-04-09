<?php

namespace Database\Factories;

use App\Models\TipoTicket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoTicketFactory extends Factory
{
    protected $model = TipoTicket::class;

    public function definition()
    {
        // Tipos comunes de tickets 
        $tipos = [
            'Soporte Técnico',
            'Prestamo de Material',
            'Consulta de Material',
            'Incidente de Seguridad',
            'Problema de Acceso',
        ];

        return [
            'nombre_tipo' => $this->faker->unique()->randomElement($tipos),
            'descripcion' => $this->faker->sentence(10), // Descripción aleatoria de 10 palabras
        ];
    }

    // Métodos rápidos para tipos específicos (opcional)
    public function soporteTecnico()
    {
        return $this->state(function (array $attributes) {
            return [
                'nombre_tipo' => 'Soporte Técnico',
                'descripcion' => 'Problemas relacionados con hardware, software o redes',
            ];
        });
    }

    public function incidenteSeguridad()
    {
        return $this->state(function (array $attributes) {
            return [
                'nombre_tipo' => 'Incidente de Seguridad',
                'descripcion' => 'Reporte de vulnerabilidades o brechas de seguridad',
            ];
        });
    }
}