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

        // 2. Tipos de ticket (requisito para tickets)
        $this->call(TiposTicketsSeeder::class);

        // 3. Estados de ticket (requisito para tickets)
        $this->call(EstadosTicketsSeeder::class);

        // 4. (Opcional) Tickets u otros seeders...
        // $this->call(TicketsSeeder::class);

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
        $this->command->info('✅  Base de datos poblada exitosamente!');
        $this->command->info('✅  База данных успешно посеяна!');
        $this->command->info('✅  Datenbank erfolgreich befüllt!');
        $this->command->info('✅  データベースのシーディングが完了しました！');
        $this->command->info(PHP_EOL);
    }
}