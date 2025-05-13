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
        // 1. Usuarios genéricos (10 aleatorios + 1 admin)
        $this->createUsers();

        // 2. Seeders
        $this->call([
            PersonasSeeder::class, // Seeder para personas (requisito para tickets)
            MaterialesSeeder::class, // Seeder para materiales (requisito para reservas)
            EstadoSeeder::class, // Seeder para estados (requisito para reservas)
            TiposTicketsSeeder::class, // Seeder para tipos de tickets (requisito para tickets)
            EstadosTicketsSeeder::class, // Seeder para estados de tickets (requisito para tickets)
            TicketsSeeder::class, // Seeder para tickets
            ReservasSeeder::class, // Seeder para reservas
        ]);

        $this->showCompletionMessage();
    }

    protected function createUsers(): void
    {
        // Usuarios aleatorios
        User::factory(10)->create();

        // Usuario admin fijo
        User::firstOrCreate(
            ['email' => 'admin@biblioteca.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password123'),
            ]
        );
    }

    protected function showCompletionMessage(): void
    {
        $this->command->info(PHP_EOL);
        $this->command->info('✅  Database seeded successfully!');
        $this->command->info('✅  База данных успешно посеяна!');
        $this->command->info(PHP_EOL);
    }
}