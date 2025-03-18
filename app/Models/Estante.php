<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estante extends Model
{
    use HasFactory;

    protected $table = 'estantes';

    protected $fillable = [
        'nombre', // Ajusta los campos según tu tabla
    ];

    // Relación con la tabla `materiales`
    public function materiales()
    {
        return $this->hasMany(Material::class, 'estantes_id');
    }
}