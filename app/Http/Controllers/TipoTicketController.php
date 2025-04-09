<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoTicket;

class TipoTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipotickets = TipoTicket::all();
        return view('tipotickets.index', compact('tipotickets'));
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, $id)
    {
        $tipoticket = TipoTicket::findOrFail($id);
        $tipoticket->estado = $request->estado;
        $tipoticket->save();

        return response()->json([
            'success' => true, 
            'message' => 'Estado actualizado correctamente',
            'newEstado' => $tipoticket->estado
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $tipoticket = TipoTicket::findOrFail($id);
            $tipoticket->delete();
            return response()->json([
                'success' => true, 
                'message' => 'Tipo de ticket eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error al eliminar el tipo de ticket'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tipotickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        TipoTicket::create($validated);

        return redirect()->route('tipotickets.index')
            ->with('success', 'Tipo de ticket creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tipoticket = TipoTicket::findOrFail($id);
        return view('tipotickets.edit', compact('tipoticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        $tipoticket = TipoTicket::findOrFail($id);
        $tipoticket->update($validated);

        return redirect()->route('tipotickets.index')
            ->with('success', 'Tipo de ticket actualizado correctamente');
    }
}