<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'idcategorias';
    protected $fillable = [
        'nombre',
        'codigoclasificacion',
        'descripcion',
        'estado',
    ];

    // Relación con la tabla `materiales`
    public function materiales()
    {
        return $this->hasMany(Material::class, 'categorias_idcategorias');
    }
}