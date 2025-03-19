<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaEvento extends Model
{

    protected $fillable = [
        'persona_id',
        'evento_id',
        'rol',
        'estado'
    ];
    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
