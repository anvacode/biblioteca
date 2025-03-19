<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTicket extends Model
{
    use HasFactory;

    protected $table = 'tipo_tickets';

    protected $fillable = [
        'nombre_tipo',
        'descripcion',
    ];
    
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'tipo_ticket_id');
    }
}