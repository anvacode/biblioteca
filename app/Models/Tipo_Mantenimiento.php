<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactories;
use Illuminate\Database\Eloquent\Model;

class Tipo_Mantenimiento extends Model
{
    protected $table = 'Tipo_Mantenimiento';
    protected $primaryKey = 'id';
    
    protected $fillable = [ 
        'nombre',
        'descripcion',
        'mantenimiento_id',
    ];

    public function mantenimiento()
    {
        return $this->hasMany(Mantenimiento::class, 'mantenimiento_id');
    }
}
