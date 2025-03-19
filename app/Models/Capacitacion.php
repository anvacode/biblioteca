<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacitacion extends Model
{
    use HasFactory;

    protected $table = 'capacitaciones';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha',
        'hora',
        'persona_id',
    ];

    /**
     * Relación con el modelo Persona
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}
