<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactories;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'Inventario';
    protected $primaryKey = 'id';
    
    protected $fillable = [ 
        'persona_id',
        'nombre',
        'descripcion',
        'fecha',
    ];

    public function personas()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}
