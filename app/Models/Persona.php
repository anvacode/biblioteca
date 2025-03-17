<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id_persona';
    protected $fillable = [
        'nombre_persona',
        'n_documento',
        'telefono',
        'correo',
    ];

    // Relación con la tabla `materiales`
    public function materiales()
    {
        return $this->hasMany(Material::class, 'personas_id_persona');
    }
}