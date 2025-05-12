<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserva;
use App\Models\Persona;
use App\Models\Material;
use App\Models\Estado;
use Carbon\Carbon;

class ReservasSeeder extends Seeder
{
    public function run()
    {
        // Obtener personas, materiales y estados existentes
        $personas = Persona::all();
        $materiales = Material::all();
        $estados = Estado::all(); // Usar el modelo Estado para obtener los registros

        // Verificar que las colecciones no estén vacías
        if ($personas->isEmpty() || $materiales->isEmpty() || $estados->isEmpty()) {
            throw new \Exception('Asegúrate de que las tablas `personas`, `materiales` y `estados` estén pobladas.');
        }

        // Crear reservas
        foreach ($personas as $persona) {
            Reserva::create([
                'fecha_reserva' => Carbon::now()->addDays(rand(1, 30)),
                'estado' => $estados->random()->nombre,
                'personas_id' => $persona->id,
                'materiales_id' => $materiales->random()->id, // Asegúrate de que se asigne un material válido
            ]);
        }
    }
}