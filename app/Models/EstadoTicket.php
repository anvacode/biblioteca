<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoTicket extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional, si sigue la convención de nombres de Laravel)
    protected $table = 'estados_tickets';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre_estado',
    ];

    // Relación con la tabla `tickets` (si existe)
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'estado_ticket_id');
    }
}