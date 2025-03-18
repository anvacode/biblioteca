<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional, si sigue la convención de nombres de Laravel)
    protected $table = 'materiales';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'clasificaciones_id',
        'categorias_id',
        'estantes_id',
        'titulo',
        'isbn',
        'anyo',
        'estado',
        'registradoPor',
    ];

    // Relación con la tabla `clasificaciones`
    public function clasificacion()
    {
        return $this->belongsTo(Clasificacion::class, 'clasificaciones_id');
    }

    // Relación con la tabla `categorias`
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categorias_id');
    }

    // Relación con la tabla `estantes`
    public function estante()
    {
        return $this->belongsTo(Estante::class, 'estantes_id');
    }
}