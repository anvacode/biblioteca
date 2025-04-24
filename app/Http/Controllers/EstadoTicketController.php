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

    public function create()
    {
        return view('estadostickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_estado' => 'required|string|max:255',
            'color' => 'required|string|max:7', // Validación para el color hexadecimal
            'orden' => 'required|integer|min:0',
        ]);

        EstadoTicket::create($request->all());

        return redirect()->route('estados-tickets.index')->with('success', 'Estado creado correctamente.');
    }

    public function edit($id)
    {
        $estado = EstadoTicket::findOrFail($id);
        return view('estadostickets.edit', compact('estado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_estado' => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'orden' => 'required|integer|min:0',
        ]);

        $estado = EstadoTicket::findOrFail($id);
        $estado->update($request->all());

        return redirect()->route('estados-tickets.index')->with('success', 'Estado actualizado correctamente.');
    }

    public function destroy($id)
    {
        $estado = EstadoTicket::findOrFail($id);

        // Verificar si el estado tiene tickets asociados
        if ($estado->tickets_count > 0) {
            return response()->json(['error' => 'No se puede eliminar un estado con tickets asociados.'], 400);
        }

        $estado->delete();

        return response()->json(['success' => 'Estado eliminado correctamente.']);
    }

    public function updateStatus(Request $request, $id)
    {
        $estado = EstadoTicket::findOrFail($id);

        // Actualizar el estado
        $estado->activo = $request->estado;
        $estado->save();

        return response()->json([
            'success' => true,
            'message' => 'El estado ha sido actualizado correctamente.'
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
