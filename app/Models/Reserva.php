<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'fecha_reserva',
        'estado',
        'personas_id',
        'materiales_id',
    ];

    // Relación con la tabla `personas`
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'personas_id');
    }

    // Relación con la tabla `materiales`
    public function material()
    {
        return $this->belongsTo(Material::class, 'materiales_id');
    }
}