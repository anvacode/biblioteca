<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Primero los usuarios
        User::factory(10)->create();

        // 2. Luego los tipos de ticket (dependencia lógica)
        $this->call(TiposTicketsSeeder::class);
        
        // 3. (Opcional) Usuario de prueba específico
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@biblioteca.com',
            'password' => bcrypt('password123'),
        ]);

        $this->command->info('✔️  Base de datos sembrada exitosamente!');
    }
}