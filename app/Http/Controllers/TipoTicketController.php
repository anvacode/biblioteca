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
        $tipotickets=TipoTicket::all();
        return view('tipotickets.index', compact('tipotickets'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function cambioestadotipoticket(Request $request){
        $tipoticket = TipoTicket::find($request->id);
        $tipoticket->estado = $request->estado;
        $tipoticket->save();
    }
}
