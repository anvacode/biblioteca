<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialesSeeder extends Seeder
{
    public function run()
    {
        // Crear 10 materiales de ejemplo
        Material::factory()->count(10)->create();
    }
}
