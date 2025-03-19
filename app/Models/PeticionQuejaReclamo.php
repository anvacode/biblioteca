<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeticionQuejaReclamo extends Model
{
    use HasFactory;

    protected $table = 'peticiones_quejas_reclamos';

    protected $fillable = [
        'descripcion',
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
