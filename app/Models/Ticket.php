<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'personas_id',
        'estados_tickets',
        'tipo_tickets',
    ];

    // Relación con la tabla `personas`
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'personas_id');
    }

    // Relación con la tabla `estados_tickets`
    public function estadoTicket()
    {
        return $this->belongsTo(EstadoTicket::class, 'estados_tickets');
    }

    // Relación con la tabla `tipo_tickets`
    public function tipoTicket()
    {
        return $this->belongsTo(TipoTicket::class, 'tipo_tickets');
    }
}