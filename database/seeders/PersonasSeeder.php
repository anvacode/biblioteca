<?php

namespace Database\Seeders;

use App\Models\Persona;
use Illuminate\Database\Seeder;

class PersonasSeeder extends Seeder
{
    public function run()
    {
        Persona::factory()->count(20)->create(); 
    }
}