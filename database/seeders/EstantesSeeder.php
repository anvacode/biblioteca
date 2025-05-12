<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estante;

class EstantesSeeder extends Seeder
{
    public function run()
    {
        Estante::factory()->count(10)->create(); // Crear 10 estantes de ejemplo
    }
}