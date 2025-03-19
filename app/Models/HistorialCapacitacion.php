<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialCapacitacion extends Model
{
    use HasFactory;

    protected $table = 'historiales_capacitaciones';

    protected $fillable = [
        'descripcion',
        'fecha', 
        'persona_id',
        'capacitacion_id',
    ];

    /**
     * Relación con el modelo Persona
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    /**
     * Relación con el modelo Capacitacion
     */
    public function capacitacion()
    {
        return $this->belongsTo(Capacitacion::class, 'capacitacion_id');
    }
}
