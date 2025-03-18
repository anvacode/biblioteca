<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional, si sigue la convención de nombres de Laravel)
    protected $table = 'tipo_documento';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'abreviatura',
    ];

    // Relación con la tabla `personas`
    public function personas()
    {
        return $this->hasMany(Persona::class, 'tipoDocumento_id');
    }
}