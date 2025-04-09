<?php

namespace App\Http\Controllers;

use App\Models\HistorialTicket;
use App\Models\Ticket;
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
    try {
      $query = HistorialTicket::with(['ticket', 'persona'])
        ->orderByDesc('fecha_cambio');

      // Aplicar filtros
      $this->applyFilters($query, $request);

      $historial = $query->paginate(self::PAGINATION_LIMIT);

      return view('historial-tickets.index', [
        'historial' => $historial,
        'tickets' => Ticket::all(),
        'currentTicket' => $request->ticket_id ? Ticket::find($request->ticket_id) : null,
        'error' => null
      ]);
    } catch (\Exception $e) {
      Log::error('Error al obtener historial de tickets: ' . $e->getMessage());

      // Devolver la vista con mensaje de error en lugar de redirección
      return view('historial-tickets.index', [
        'historial' => collect(), // Colección vacía
        'tickets' => Ticket::all(),
        'currentTicket' => null,
        'error' => 'Ocurrió un error al cargar el historial'
      ]);
    }
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
      'persona_responsable' => 'required|string|max:' . self::MAX_RESPONSIBLE_LENGTH
    ]);

    try {
      HistorialTicket::create([
        'tickets_idtickets' => $ticket->id,
        'personas_id' => Auth::id() ?? $request->personas_id,
        'fecha_cambio' => now(),
        'comentario' => $validated['comentario'],
        'persona_responsable' => $validated['persona_responsable']
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
      $historial = HistorialTicket::where('tickets_idtickets', $ticket->id)
        ->with('persona')
        ->orderByDesc('fecha_cambio')
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
      $historial = HistorialTicket::where('tickets_idtickets', $ticket->id)
        ->with(['persona', 'ticket'])
        ->orderByDesc('fecha_cambio')
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
      $query->where('tickets_idtickets', $request->ticket_id);
    }

    if ($request->fecha_inicio && $request->fecha_fin) {
      $query->whereBetween('fecha_cambio', [
        Carbon::parse($request->fecha_inicio)->startOfDay(),
        Carbon::parse($request->fecha_fin)->endOfDay()
      ]);
    }
  }
}