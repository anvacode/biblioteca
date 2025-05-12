<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriasSeeder extends Seeder
{
    public function run()
    {
        // Crear 10 categorías de ejemplo
        Categoria::factory()->count(10)->create();
    }
}