<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materiales';
    protected $primaryKey = 'id';

    protected $fillable = [
        'titulo',
        'isbn',
        'anyo',
        'estado',
        'registradoPor',
        'clasificaciones_id',
        'categorias_id',
        'estantes_id',
    ];

    public function clasificacion()
    {
        return $this->belongsTo(Clasificacion::class, 'clasificaciones_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categorias_id');
    }

    public function estante()
    {
        return $this->belongsTo(Estante::class, 'estantes_id');
    }

    public function materialAutor()
    {
        return $this->hasMany(MaterialAutor::class, 'materialAutor_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'personas_id_persona');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'materiales_id');
    }
}
