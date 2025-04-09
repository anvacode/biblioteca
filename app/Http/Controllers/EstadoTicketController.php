<?php

namespace App\Http\Controllers;

use App\Models\EstadoTicket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EstadoTicketController extends Controller
{
    // Estados del sistema que no pueden eliminarse
    private $protectedStates = ['Abierto', 'En progreso', 'Cerrado'];

    /**
     * Display a listing of ticket states.
     */
    public function index()
    {
        $estados = EstadoTicket::withCount('tickets')
            ->orderBy('nombre_estado')
            ->get();

        return view('estados-tickets.index', [
            'estados' => $estados,
            'protectedStates' => $this->protectedStates
        ]);
    }

    /**
     * Store a newly created ticket state.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_estado' => [
                'required',
                'string',
                'max:50',
                'unique:estados_tickets,nombre_estado',
                'not_in:' . implode(',', $this->protectedStates)
            ]
        ], [
            'nombre_estado.not_in' => 'Este nombre de estado está reservado para el sistema.'
        ]);

        EstadoTicket::create($validated);

        return redirect()->route('estados-tickets.index')
            ->with('success', 'Estado creado exitosamente!');
    }

    /**
     * Update the specified ticket state.
     */
    public function update(Request $request, EstadoTicket $estadoTicket)
    {
        // Verificar si es un estado protegido
        if (in_array($estadoTicket->nombre_estado, $this->protectedStates)) {
            return back()->with('error', 'No puedes editar este estado del sistema.');
        }

        $validated = $request->validate([
            'nombre_estado' => [
                'required',
                'string',
                'max:50',
                Rule::unique('estados_tickets')->ignore($estadoTicket->id),
                'not_in:' . implode(',', $this->protectedStates)
            ]
        ]);

        $estadoTicket->update($validated);

        return back()->with('success', 'Estado actualizado!');
    }

    /**
     * Remove the specified ticket state.
     */
    public function destroy(EstadoTicket $estadoTicket)
    {
        // Verificar si es un estado protegido
        if (in_array($estadoTicket->nombre_estado, $this->protectedStates)) {
            return back()->with('error', 'No puedes eliminar este estado del sistema.');
        }

        // Verificar si tiene tickets asociados
        if ($estadoTicket->tickets()->exists()) {
            return back()->with('error', 'No puedes eliminar un estado con tickets asociados.');
        }

        $estadoTicket->delete();

        return redirect()->route('estados-tickets.index')
            ->with('success', 'Estado eliminado!');
    }

    /**
     * API: Get all ticket states (for dropdowns)
     */
    public function apiEstados()
    {
        return response()->json(EstadoTicket::all());
    }
}