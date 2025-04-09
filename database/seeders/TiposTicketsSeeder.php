<?php

namespace Database\Seeders;

use App\Models\TipoTicket;
use Illuminate\Database\Seeder;

class TiposTicketsSeeder extends Seeder
{
    public function run()
    {
        $tipos = [
            [
                'nombre_tipo' => 'Soporte Técnico',
                'descripcion' => 'Problemas con hardware, software o redes internas'
            ],
            [
                'nombre_tipo' => 'Solicitud de Función',
                'descripcion' => 'Nuevas funcionalidades requeridas por el usuario'
            ],
            [
                'nombre_tipo' => 'Error en Sistema',
                'descripcion' => 'Fallos críticos o bugs en producción'
            ],
            [
                'nombre_tipo' => 'Consulta General',
                'descripcion' => 'Preguntas sobre el uso del sistema'
            ],
            [
                'nombre_tipo' => 'Incidente de Seguridad',
                'descripcion' => 'Vulnerabilidades o accesos no autorizados'
            ]
        ];

        foreach ($tipos as $tipo) {
            TipoTicket::firstOrCreate(
                ['nombre_tipo' => $tipo['nombre_tipo']],
                $tipo
            );
        }

        $this->command->info('¡5 tipos de tickets creados exitosamente!');
    }
}