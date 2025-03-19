<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactories;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    protected $table = 'Mantenimiento';
    protected $primaryKey = 'id';
    
    protected $fillable = [ 
        'nombre',
        'persona_id',
        'tipo_mantenimiento_id',
        'estado_id',
        'historico_mantenimiento_id',
        'descripcion'
    ];


    public function tipos_mantenimientos(){
        return $this->toBelong(Tipo_Mantenimiento::class,'tipo_mantenimiento_id');
    }
    public function estados(){
        return $this->toBelong(Estado::class,'estado_id');
    }
    public function historicos_mantenimientos(){
        return $this->hasMany(Historico_Mantenimiento::class,'historico_mantenimiento_id');
    }
    public function personas(){
        return $this->toBelong(Persona::class,'persona_id');
    }
}
