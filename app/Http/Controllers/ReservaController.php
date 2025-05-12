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
        $materiales = Material::where('estado', 'disponible')->get(); // Filtrar materiales disponibles

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
                function ($attribute, $value, $fail) {
                    $material = Material::find($value);
                    if ($material->estado !== 'disponible') {
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

        // Actualizar estado del material
        Material::where('id', $validated['materiales_id'])
                ->update(['estado' => 'reservado']);

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
     * Show the form for editing the specified reservation.
     */
    public function edit(Reserva $reserva)
    {
        $personas = Persona::orderBy('nombre')->get();
        $materiales = Material::all();

        return view('reservas.edit', compact('reserva', 'personas', 'materiales'));
    }

    /**
     * Update the specified reservation in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        $validated = $request->validate([
            'fecha_reserva' => 'required|date|after_or_equal:today',
            'estado' => 'required|in:pendiente,confirmada,cancelada',
            'personas_id' => 'required|exists:personas,id',
            'materiales_id' => 'required|exists:materiales,id',
        ]);

        $reserva->update($validated);

        return redirect()->route('reservas.index')
               ->with('success', 'Reserva actualizada exitosamente!');
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
            $reserva->material()->update(['estado' => 'disponible']);
        }

        return back()->with('success', 'Estado actualizado!');
    }

    /**
     * Remove the specified reservation from storage.
     */
    public function destroy(Reserva $reserva)
    {
        $reserva->delete();

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva eliminada exitosamente.');
    }
}