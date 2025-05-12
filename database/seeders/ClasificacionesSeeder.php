<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clasificacion;

class ClasificacionesSeeder extends Seeder
{
    public function run()
    {
        Clasificacion::factory()->count(10)->create(); // Crear 10 clasificaciones de ejemplo
    }
}