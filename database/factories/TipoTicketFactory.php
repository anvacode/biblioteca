<?php

namespace Database\Factories;

use App\Models\TipoTicket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoTicketFactory extends Factory
{
    protected $model = TipoTicket::class;

    public function definition()
    {
        $tipos = [
            'Soporte Técnico' => 'Problemas con hardware, software o equipos',
            'Préstamo de Material' => 'Solicitud de préstamo de equipos o materiales',
            'Consulta de Material' => 'Consultas sobre disponibilidad de materiales',
            'Incidente de Seguridad' => 'Reporte de vulnerabilidades de seguridad',
            'Problema de Acceso' => 'Dificultades para acceder a sistemas',
            'Mantenimiento Preventivo' => 'Solicitud de mantenimiento programado',
            'Capacitación' => 'Petición de entrenamiento o capacitación',
            'Solicitud de Software' => 'Petición para instalación de programas',
            'Problema de Red' => 'Inconvenientes con la conectividad',
            'Configuración de Email' => 'Problemas con clientes de correo'
        ];

        $tipo = $this->faker->randomElement(array_keys($tipos));
        
        return [
            'nombre' => $tipo,
            'descripcion' => $tipos[$tipo],
            'estado' => $this->faker->boolean(90),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }

    // Métodos de estado para tipos específicos
    public function soporteTecnico()
    {
        return $this->state([
            'nombre' => 'Soporte Técnico',
            'descripcion' => 'Problemas relacionados con hardware, software o redes',
            'estado' => true
        ]);
    }

    public function incidenteSeguridad()
    {
        return $this->state([
            'nombre' => 'Incidente de Seguridad',
            'descripcion' => 'Reporte de vulnerabilidades o brechas de seguridad',
            'estado' => true
        ]);
    }

    public function prestamoMaterial()
    {
        return $this->state([
            'nombre' => 'Préstamo de Material',
            'descripcion' => 'Gestión de préstamos de equipos y materiales',
            'estado' => true
        ]);
    }
}