<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreacti',
        'descripcion',
        'fecha_inicio',
        'fecha_final',
        'lugar'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function materiales()
    {
        return $this->belongsToMany(Material::class, 'actividad_materiales');
    }
}
