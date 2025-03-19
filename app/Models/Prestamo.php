<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $table = 'prestamos'; 
    protected $primaryKey = 'id'; 
    protected $fillable = [
        'fecha_prestamo',
        'estado',
        'persona_id', 
        'material_id', 
        'fecha_devolucion',
        'fecha_entrega',
        'dias_retraso'
    ];

   
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
    public function multaPrestamos()
    {
        return $this->hasMany(MultaPrestamo::class, 'prestamo_id');
    }
}

