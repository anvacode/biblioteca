<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoTicket extends Model
{
    use HasFactory;

    protected $table = 'estados_tickets';

    protected $fillable = [
        'nombre_estado',
        'color',
        'orden',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'estado_ticket_id');
    }

    public static function getProtectedStates()
    {
        return ['Abierto', 'En progreso', 'Cerrado'];
    }

    public function isProtected()
    {
        return in_array($this->nombre_estado, self::getProtectedStates());
    }
}