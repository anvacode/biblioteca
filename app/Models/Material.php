<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'titulo', 
        'isbn', 
        'anio', 
        'estado',    
        'registrado_por', 
        'clasificacion_id'
    ];

    public function materiales()
    {
        return $this->hasMany(Material::class, 'clasificacion_id');
    }
}
