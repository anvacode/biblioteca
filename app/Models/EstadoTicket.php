<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoTicket extends Model
{
    use HasFactory;

    protected $table = 'estados_tickets'; 

    protected $fillable = ['nombre_estado'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'estado_ticket_id');
    }

    // Define los estados protegidos
    public static $protectedStates = ['Estado Inicial', 'Estado Final'];

    // Método para verificar si el estado está protegido
    public function isProtected()
    {
        return in_array($this->nombre_estado, self::$protectedStates);
    }

    // Método para obtener los estados protegidos
    public static function getProtectedStates()
    {
        return self::$protectedStates;
    }
}