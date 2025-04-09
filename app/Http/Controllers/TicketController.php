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
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $query = Ticket::with(['persona', 'estadoTicket', 'tipoTicket'])
                ->orderByDesc('created_at');

            // Apply filters
            $this->applyFilters($query, $request);

            $tickets = $query->paginate(self::PAGINATION_LIMIT);

            return view('tickets.index', [
                'tickets' => $tickets,
                'estados' => EstadoTicket::all(),
                'tipos' => TipoTicket::all(),
                'currentEstado' => $request->estado,
                'currentTipo' => $request->tipo
            ]);

        } catch (\Exception $e) {
            report($e);
            return view('tickets.index', [
                'tickets' => collect(),
                'estados' => EstadoTicket::all(),
                'tipos' => TipoTicket::all(),
                'error' => 'Error al cargar los tickets'
            ]);
        }
    }

    /**
     * Show the form for creating a new ticket.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('tickets.create', [
            'personas' => Persona::orderBy('nombre')->get(),
            'estados' => EstadoTicket::all(),
            'tipos' => TipoTicket::all()
        ]);
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
            'personas_id' => 'required|exists:personas,id',
            'estados_tickets_id' => 'required|exists:estados_tickets,id',
            'tipo_tickets_id' => 'required|exists:tipo_tickets,id',
            'comentario' => 'required|string|max:'.self::MAX_COMMENT_LENGTH
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $ticket = Ticket::create($request->only([
                'personas_id',
                'estados_tickets_id',
                'tipo_tickets_id'
            ]));

            // Register in history
            HistorialTicket::create([
                'tickets_idtickets' => $ticket->id,
                'personas_id' => Auth::id() ?? $request->personas_id,
                'comentario' => $request->comentario,
                'fecha_cambio' => now()
            ]);

            return redirect()->route('tickets.show', $ticket)
                ->with('success', 'Ticket creado exitosamente!');

        } catch (\Exception $e) {
            report($e);
            return back()->with('error', 'Error al crear el ticket')->withInput();
        }
    }

    /**
     * Display the specified ticket with history.
     * 
     * @param Ticket $ticket
     * @return \Illuminate\View\View
     */
    public function show(Ticket $ticket)
    {
        return view('tickets.show', [
            'ticket' => $ticket->load(['historial.persona', 'estadoTicket', 'tipoTicket']),
            'estados' => EstadoTicket::all(),
            'closableStates' => self::CLOSABLE_STATES
        ]);
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
            'estados_tickets_id' => 'required|exists:estados_tickets,id',
            'comentario' => 'required_if:estados_tickets_id,'.EstadoTicket::where('nombre_estado', 'Cerrado')->first()->id
        ]);

        try {
            $nuevoEstado = EstadoTicket::findOrFail($request->estados_tickets_id);

            // Validate state transition
            if ($nuevoEstado->nombre_estado == 'Cerrado' && 
                !in_array($ticket->estadoTicket->nombre_estado, self::CLOSABLE_STATES)) {
                return back()->with('error', 'No puedes cerrar un ticket en estado actual.');
            }

            $ticket->update(['estados_tickets_id' => $request->estados_tickets_id]);

            // Register in history
            HistorialTicket::create([
                'tickets_idtickets' => $ticket->id,
                'personas_id' => Auth::id(),
                'comentario' => $request->comentario ?? 'Cambio de estado a '.$nuevoEstado->nombre_estado,
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
            'comentario' => 'required|string|max:'.self::MAX_COMMENT_LENGTH
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
                $query->whereHas('estadoTicket', function($q) use ($request) {
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
            $query->whereHas('estadoTicket', function($q) use ($request) {
                $q->where('nombre_estado', $request->estado);
            });
        }

        if ($request->tipo) {
            $query->whereHas('tipoTicket', function($q) use ($request) {
                $q->where('nombre_tipo', $request->tipo);
            });
        }
    }
}