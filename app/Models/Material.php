<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materiales';

    protected $primaryKey = 'id_materiales';

    protected $fillable = [
        'titulo', 
        'isbn', 
        'anyo',  
        'estante',
        'estado',    
        'registradoPor',  
        'fecha',
        'personas_id_persona',  // Clave foránea
        'categorias_idcategorias',  // Clave foránea
        'editoriales_ideditoriales',  // Clave foránea
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'personas_id_persona');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categorias_idcategorias');
    }

    public function editorial()
    {
        return $this->belongsTo(Editorial::class, 'editoriales_ideditoriales');
    }

    public function ejemplares()
    {
        return $this->hasMany(Ejemplar::class, 'materiales_id_materiales');
    }
}