<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreevento',
        'descripcion',
        'fecha_inicio',
        'fecha_final',
        'lugar',
        'status',
        'maxparticipantes',
        'user_id'
    ];

    public function personas()
    {
        return $this->belongsToMany(Persona::class, 'persona_eventos');
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class);
    }
}
