<?php

namespace App\Http\Controllers;

use App\Models\EstadoTicket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EstadoTicketController extends Controller
{
    public function index()
    {
        $estados = EstadoTicket::withCount('tickets')
            ->orderBy('orden')
            ->orderBy('nombre_estado')
            ->get();

        return view('estadostickets.index', [
            'estados' => $estados,
            'protectedStates' => EstadoTicket::getProtectedStates()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_estado' => [
                'required',
                'string',
                'max:50',
                'unique:estados_tickets,nombre_estado',
                'not_in:' . implode(',', EstadoTicket::getProtectedStates())
            ],
            'color' => 'required|string|size:7|starts_with:#',
            'orden' => 'required|integer|min:0'
        ], [
            'nombre_estado.not_in' => 'Este nombre de estado está reservado para el sistema.',
            'color.starts_with' => 'El color debe ser un código hexadecimal válido (ej. #FF0000).'
        ]);

        EstadoTicket::create($validated);

        return redirect()->route('estados-tickets.index')
            ->with('success', 'Estado creado exitosamente!');
    }

    public function update(Request $request, EstadoTicket $estados_ticket)
    {
        if ($estados_ticket->isProtected()) {
            return back()->with('error', 'No puedes editar este estado del sistema.');
        }

        $validated = $request->validate([
            'nombre_estado' => [
                'required',
                'string',
                'max:50',
                Rule::unique('estados_tickets')->ignore($estados_ticket->id),
                'not_in:' . implode(',', EstadoTicket::getProtectedStates())
            ],
            'color' => 'required|string|size:7|starts_with:#',
            'orden' => 'required|integer|min:0',
            'activo' => 'sometimes|boolean'
        ]);

        $estados_ticket->update($validated);

        return back()->with('success', 'Estado actualizado!');
    }

    public function destroy(EstadoTicket $estados_ticket)
    {
        if ($estados_ticket->isProtected()) {
            return back()->with('error', 'No puedes eliminar este estado del sistema.');
        }

        if ($estados_ticket->tickets()->exists()) {
            return back()->with('error', 'No puedes eliminar un estado con tickets asociados.');
        }

        $estados_ticket->delete();

        return redirect()->route('estados-tickets.index')
            ->with('success', 'Estado eliminado permanentemente!');
    }

    public function updateStatus(Request $request, EstadoTicket $estado)
    {
        if ($estado->isProtected()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede modificar este estado del sistema'
            ], 403);
        }

        $estado->update([
            'activo' => $request->validate(['estado' => 'required|boolean'])['estado']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente',
            'nuevo_estado' => $estado->activo
        ]);
    }

    public function apiEstados()
    {
        $estados = EstadoTicket::where('activo', true)
            ->orderBy('orden')
            ->get();

        return response()->json($estados);
    }
}
