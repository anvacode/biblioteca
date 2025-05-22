<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Persona;
use App\Models\EstadoTicket;
use App\Models\TipoTicket;
use App\Models\HistorialTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;
use DataTables;
use Carbon\Carbon;

class TicketController extends Controller
{
    // Constants for configuration
    private const PAGINATION_LIMIT = 15;
    private const MAX_COMMENT_LENGTH = 500;
    private const CLOSABLE_STATES = ['Abierto', 'En progreso'];

    /**
     * Display a listing of tickets with filters.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tickets = Ticket::with(['estadoTicket', 'tipoTicket', 'persona'])->get();
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $personas = Persona::orderBy('nombre')->get();
        $estados = EstadoTicket::all();
        $tipos = TipoTicket::all();

        return view('tickets.create', compact('personas', 'estados', 'tipos'));
    }

    /**
     * Store a newly created ticket.
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado_ticket_id' => 'required|exists:estados_tickets,id',
            'tipo_ticket_id' => 'required|exists:tipo_tickets,id',
            'personas_id' => 'required|exists:personas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Ticket::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'estado_ticket_id' => $request->estado_ticket_id,
            'tipo_ticket_id' => $request->tipo_ticket_id,
            'personas_id' => $request->personas_id,
            'user_id' => Auth::id(), // Agregar el ID del usuario autenticado
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket creado exitosamente.');
    }

    /**
     * Display the specified ticket with history.
     * 
     * @param Ticket $ticket
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $ticket = Ticket::with(['estadoTicket', 'tipoTicket', 'persona'])->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified ticket.
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $ticket = Ticket::with(['estadoTicket', 'tipoTicket', 'persona'])->findOrFail($id);
        $personas = Persona::orderBy('nombre')->get();
        $estados = EstadoTicket::all();
        $tipos = TipoTicket::all();

        return view('tickets.edit', compact('ticket', 'personas', 'estados', 'tipos'));
    }

    /**
     * Update the specified ticket.
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado_ticket_id' => 'required|exists:estados_tickets,id', // Cambiado a 'estados_tickets'
            'tipo_ticket_id' => 'required|exists:tipo_tickets,id',
            'personas_id' => 'required|exists:personas,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->only(['titulo', 'descripcion', 'estado_ticket_id', 'tipo_ticket_id', 'personas_id']));

        return redirect()->route('tickets.index')->with('success', 'Ticket actualizado exitosamente.');
    }

    /**
     * Update the ticket status.
     * 
     * @param Request $request
     * @param Ticket $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'estado_ticket_id' => 'required|exists:estado_tickets,id',
            'comentario' => 'required_if:estado_ticket_id,' . EstadoTicket::where('nombre_estado', 'Cerrado')->value('id')
        ]);

        try {
            $nuevoEstado = EstadoTicket::findOrFail($request->estado_ticket_id);

            // Validate state transition
            if (
                $nuevoEstado->nombre_estado == 'Cerrado' &&
                !in_array($ticket->estadoTicket->nombre_estado, self::CLOSABLE_STATES)
            ) {
                return back()->with('error', 'No puedes cerrar un ticket en estado actual.');
            }

            $ticket->update(['estados_tickets_id' => $request->estado_ticket_id]);

            // Register in history
            HistorialTicket::create([
                'tickets_idtickets' => $ticket->id,
                'personas_id' => Auth::id(),
                'comentario' => $request->comentario ?? 'Cambio de estado a ' . $nuevoEstado->nombre_estado,
                'fecha_cambio' => now()
            ]);

            return back()->with('success', 'Estado actualizado!');
        } catch (\Exception $e) {
            report($e);
            return back()->with('error', 'Error al actualizar el estado');
        }
    }

    /**
     * Add comment to ticket history.
     * 
     * @param Request $request
     * @param Ticket $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addComment(Request $request, Ticket $ticket)
    {
        $request->validate([
            'comentario' => 'required|string|max:' . self::MAX_COMMENT_LENGTH
        ]);

        try {
            HistorialTicket::create([
                'tickets_idtickets' => $ticket->id,
                'personas_id' => Auth::id(),
                'comentario' => $request->comentario,
                'fecha_cambio' => now()
            ]);

            return back()->with('success', 'Comentario agregado!');
        } catch (\Exception $e) {
            report($e);
            return back()->with('error', 'Error al agregar el comentario');
        }
    }

    /**
     * API: Get tickets for datatables.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiTickets(Request $request)
    {
        try {
            $query = Ticket::with(['persona', 'estadoTicket', 'tipoTicket']);

            if ($request->has('estado')) {
                $query->whereHas('estadoTicket', function ($q) use ($request) {
                    $q->where('nombre_estado', $request->estado);
                });
            }

            return datatables()->eloquent($query)->toJson();
        } catch (\Exception $e) {
            report($e);
            return response()->json(['error' => 'Error al cargar los datos'], 500);
        }
    }

    /**
     * Apply filters to the query
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Request $request
     */
    private function applyFilters($query, Request $request)
    {
        if ($request->estado) {
            $query->whereHas('estadoTicket', function ($q) use ($request) {
                $q->where('nombre_estado', $request->estado);
            });
        }

        if ($request->tipo) {
            $query->whereHas('tipoTicket', function ($q) use ($request) {
                $q->where('nombre_tipo', $request->tipo);
            });
        }
    }

    /**
     * Remove the specified ticket.
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->delete();

            return redirect()->route('tickets.index')->with('success', 'Ticket eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('tickets.index')->with('error', 'Ocurrió un error al intentar eliminar el ticket.');
        }
    }

    public function generatePDF(Ticket $ticket)
    {
        $pdf = PDF::loadView('tickets.pdf', compact('ticket'))->setPaper('letter');
        return $pdf->stream('ticket_' . $ticket->id . '.pdf');
    }

    public function printAll()
    {
        // Cargar todos los tickets con paginación
        $tickets = Ticket::with(['estadoTicket', 'tipoTicket', 'persona'])
            ->orderBy('created_at', 'desc')
            ->chunk(100, function ($chunk) {
                // Procesar en chunks para evitar memory limits
            });

        // Cargar todos los tickets con sus relaciones
        $tickets = Ticket::with(['estadoTicket', 'tipoTicket', 'persona'])->get();

        // Verificar si hay tickets
        if ($tickets->isEmpty()) {
            return redirect()->back()->with('warning', 'No hay tickets para imprimir');
        }

        $pdf = PDF::loadView('tickets.printAll', compact('tickets'))
            ->setPaper('letter', 'landscape')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream('todos_los_tickets.pdf');
    }
}
