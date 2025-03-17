<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    protected $table = 'editoriales';
    protected $primaryKey = 'ideditoriales';
    protected $fillable = [
        'nombre',
        'nit',
    ];

    // Relación con la tabla `materiales`
    public function materiales()
    {
        return $this->hasMany(Material::class, 'editoriales_ideditoriales');
    }
}