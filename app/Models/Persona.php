<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional, si sigue la convención de nombres de Laravel)
    protected $table = 'personas';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'N_documento',
        'correo',
        'telefono',
        'tipoDocumento_id',
    ];

    // Relación con la tabla `tipo_documento`
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipoDocumento_id');
    }
}