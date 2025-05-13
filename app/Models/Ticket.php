<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titulo',
        'descripcion',
        'estado_ticket_id',
        'tipo_ticket_id',
        'personas_id',
        'user_id', 
    ];

    // Relación con EstadoTicket
    public function estadoTicket()
    {
        return $this->belongsTo(EstadoTicket::class, 'estado_ticket_id');
    }

    // Relación con TipoTicket
    public function tipoTicket()
    {
        return $this->belongsTo(TipoTicket::class, 'tipo_ticket_id');
    }

    // Relación con Persona
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'personas_id'); // Cambiado de 'persona_id' a 'personas_id'
    }
}