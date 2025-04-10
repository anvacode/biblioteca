<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'personas_id', // Mantenemos este si no quieres cambiarlo
        'estado_ticket_id', // Cambiado
        'tipo_ticket_id' // Cambiado
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'personas_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoTicket::class, 'estado_ticket_id');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoTicket::class, 'tipo_ticket_id');
    }
}