<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPeticionQuejaReclamo extends Model
{
    use HasFactory;

    protected $table = 'tipos_peticiones_quejas_reclamos';

    protected $fillable = [
        'tipo',
        'peticion_queja_reclamo_id',
    ];

    /**
     * Relación con el modelo PeticionQuejaReclamo
     */
    public function peticionQuejaReclamo()
    {
        return $this->belongsTo(PeticionQuejaReclamo::class, 'peticion_queja_reclamo_id');
    }
}
