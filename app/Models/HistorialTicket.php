<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HistorialTicket
 *
 * @property int $id
 * @property int $tipo_ticket_id
 * @property string|null $accion
 * @property string|null $comentario
 * @property string|null $detalles
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Ticket $ticket
 * @property-read \App\Models\User $usuario
 */
class HistorialTicket extends Model
{
    use HasFactory;

    protected $table = 'historial_tickets';

    protected $fillable = [
        'tipo_ticket_id',
        'accion',
        'comentario',
        'detalles',
        'user_id',
    ];

    /**
     * Casts para fechas
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con la tabla `tickets`
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'tipo_ticket_id');
    }

    /**
     * Relación con la tabla `users`
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}