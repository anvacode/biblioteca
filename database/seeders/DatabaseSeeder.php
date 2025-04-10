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

        $this->call([EstadosTicketsSeeder::class,]);

        // 3. (Opcional) Usuario de prueba específico
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@biblioteca.com',
            'password' => bcrypt('password123'),
        ]);
        
        $this->command->info('✔️  The database has been seeded successfully!');
        $this->command->info('✔️  Die Datenbank wurde erfolgreich befüllt!');
        $this->command->info('✔️  База данных успешно засеяна!');
        $this->command->info('✔️  データベースが正常にシードされた！');
    }
}
