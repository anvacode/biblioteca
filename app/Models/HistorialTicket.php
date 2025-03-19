<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialTicket extends Model
{
    use HasFactory;

    protected $table = 'historial_tickets';

    protected $fillable = [
        'personas_id',
        'tickets_idtickets',
        'fecha_cambio',
        'comentario',
        'persona_responsable',
    ];

    // Relación con la tabla `personas`
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'personas_id');
    }

    // Relación con la tabla `tickets`
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'tickets_idtickets');
    }
}