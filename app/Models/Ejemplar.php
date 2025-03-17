<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejemplar extends Model
{
    protected $table = 'ejemplares';
    protected $primaryKey = 'idejemplar';
    protected $fillable = [
        'codigo',
        'estado',
        'materiales_id_materiales',
    ];

    // Relación con la tabla `materiales`
    public function material()
    {
        return $this->belongsTo(Material::class, 'materiales_id_materiales');
    }
}