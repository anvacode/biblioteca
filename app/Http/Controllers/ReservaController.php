<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Persona;
use App\Models\Material;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Display a listing of reservations.
     */
    public function index()
    {
        $reservas = Reserva::with(['persona', 'material'])
                    ->orderBy('fecha_reserva', 'desc')
                    ->get();
        
        return view('reservas.index', compact('reservas'));
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create()
    {
        $personas = Persona::orderBy('nombre')->get();
        $materiales = Material::where('disponible', true)->get();
        
        return view('reservas.create', compact('personas', 'materiales'));
    }

    /**
     * Store a newly created reservation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha_reserva' => 'required|date|after_or_equal:today',
            'personas_id' => 'required|exists:personas,id',
            'materiales_id' => [
                'required',
                'exists:materiales,id',
                function ($attribute, $value, $fail) use ($request) {
                    $material = Material::find($value);
                    if (!$material->disponible) {
                        $fail('El material seleccionado no está disponible.');
                    }
                }
            ]
        ], [
            'fecha_reserva.after_or_equal' => 'La fecha no puede ser anterior a hoy.'
        ]);

        Reserva::create([
            'fecha_reserva' => Carbon::parse($validated['fecha_reserva']),
            'estado' => 'pendiente',
            'personas_id' => $validated['personas_id'],
            'materiales_id' => $validated['materiales_id']
        ]);

        // Actualizar disponibilidad del material
        Material::where('id', $validated['materiales_id'])
                ->update(['disponible' => false]);

        return redirect()->route('reservas.index')
               ->with('success', 'Reserva creada exitosamente!');
    }

    /**
     * Display the specified reservation.
     */
    public function show(Reserva $reserva)
    {
        return view('reservas.show', compact('reserva'));
    }

    /**
     * Update the reservation status.
     */
    public function updateStatus(Request $request, Reserva $reserva)
    {
        $request->validate([
            'estado' => 'required|in:confirmada,cancelada,completada'
        ]);

        $reserva->update(['estado' => $request->estado]);

        // Si se cancela o completa, liberar el material
        if (in_array($request->estado, ['cancelada', 'completada'])) {
            $reserva->material()->update(['disponible' => true]);
        }

        return back()->with('success', 'Estado actualizado!');
    }

    /**
     * Remove the specified reservation.
     */
    public function destroy(Reserva $reserva)
    {
        // Liberar el material antes de eliminar
        $reserva->material()->update(['disponible' => true]);
        
        $reserva->delete();
        
        return redirect()->route('reservas.index')
               ->with('success', 'Reserva eliminada!');
    }
}