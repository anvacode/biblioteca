<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactories;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'Estado';
    protected $primaryKey = 'id';
    
    protected $fillable = [ 
        'nombre',
        'mantenimiento_id',
    ];

    public function mantenimiento(){
        return $this->hasMany(Mantenimiento::class,'mantenimiento_id');
    }

}
