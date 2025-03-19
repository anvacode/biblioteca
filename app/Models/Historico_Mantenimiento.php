<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactories;
use Illuminate\Database\Eloquent\Model;

class Historico_Mantenimiento extends Model
{
    protected $table = 'Historico_Mantenimiento';
    protected $primaryKey = 'id';
    
    protected $fillable = [ 
        'nombre',
        'mantenimiento_id',
        'descripcion',
    ];

    public function mantenimientos(){
        return $this->toBelong(Mantenimiento::class,'mantenimiento_id');
    }
}
