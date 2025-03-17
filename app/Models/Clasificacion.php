<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clasificacion extends Model
{
    use HasFactory;

    protected $table = 'clasificacion';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
        'registrado_por'
    ];

    public function clasificacion()
    {
        return $this->belongsToMany(Clasificacion::class);
    }
}
