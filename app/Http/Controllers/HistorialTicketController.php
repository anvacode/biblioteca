<?php

namespace App\Http\Controllers;

use App\Models\HistorialTicket;
use App\Models\Ticket;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HistorialTicketController extends Controller
{
    private const PAGINATION_LIMIT = 20;
    private const MAX_COMMENT_LENGTH = 500;
    private const MAX_RESPONSIBLE_LENGTH = 100;

    /**
     * Muestra el historial de tickets con filtros aplicables
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = HistorialTicket::with(['ticket', 'usuario']);

        // Aplica los filtros usando el método privado
        $this->applyFilters($query, $request);

        // Obtener los resultados paginados
        $historial = $query->orderByDesc('created_at')->paginate(10);

        // Obtener los tickets para el filtro
        $tickets = Ticket::all();

        return view('historialtickets.index', compact('historial', 'tickets'));
    }

    /**
     * Almacena un nuevo registro en el historial
     * 
     * @param Request $request
     * @param Ticket $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'comentario' => 'required|string|max:' . self::MAX_COMMENT_LENGTH,
            // 'persona_responsable' => 'required|string|max:' . self::MAX_RESPONSIBLE_LENGTH // No existe en la tabla
        ]);

        try {
            HistorialTicket::create([
                'tipo_ticket_id' => $ticket->id,
                'user_id' => Auth::id() ?? $request->user_id,
                'comentario' => $validated['comentario'],
                'accion' => $request->accion ?? null,
                'detalles' => $request->detalles ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('success', 'Registro añadido al historial correctamente');
        } catch (\Exception $e) {
            Log::error('Error al crear registro de historial: ' . $e->getMessage());
            return back()->with('error', 'Error al guardar el registro');
        }
    }

    /**
     * API: Obtiene el historial de un ticket específico (JSON)
     * 
     * @param Ticket $ticket
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTicketHistory(Ticket $ticket)
    {
        try {
            $historial = HistorialTicket::where('tipo_ticket_id', $ticket->id)
                ->with('usuario')
                ->orderByDesc('created_at')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $historial,
                'ticket' => $ticket->load(['estadoTicket', 'tipoTicket'])
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener historial API: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar el historial'
            ], 500);
        }
    }

    /**
     * Exporta el historial a PDF
     * 
     * @param Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function exportPdf(Ticket $ticket)
    {
        try {
            $historial = HistorialTicket::where('tipo_ticket_id', $ticket->id)
                ->with(['usuario', 'ticket'])
                ->orderByDesc('created_at')
                ->get();

            $pdf = Pdf::loadView('pdf.historial-ticket', [
                'historial' => $historial,
                'ticket' => $ticket
            ]);

            return $pdf->download("historial-ticket-{$ticket->id}.pdf");
        } catch (\Exception $e) {
            Log::error('Error al generar PDF: ' . $e->getMessage());

            // Devolver una respuesta de error en lugar de redirección
            return response()->make('Error al generar el PDF', 500);
        }
    }

    /**
     * Elimina un registro del historial (solo administradores)
     * 
     * @param HistorialTicket $registro
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(HistorialTicket $registro)
    {
        $this->authorize('delete', $registro);

        try {
            $registro->delete();
            return back()->with('success', 'Registro eliminado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el registro');
        }
    }

    /**
     * Aplica filtros a la consulta del historial
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Request $request
     */
    private function applyFilters($query, Request $request)
    {
        if ($request->ticket_id) {
            $query->where('tipo_ticket_id', $request->ticket_id);
        }

        if ($request->fecha_inicio && $request->fecha_fin) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->fecha_inicio)->startOfDay(),
                Carbon::parse($request->fecha_fin)->endOfDay()
            ]);
        }
    }
}