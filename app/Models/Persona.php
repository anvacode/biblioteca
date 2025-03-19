<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas'; 
    protected $primaryKey = 'id'; 
    protected $fillable = [
        'nombre',
        'n_documento',
        'correo',
        'telefono',
        'total_multas',
        'tipo_documento_id',
        'mantenimiento_id',
        'inventario_id',
    ];

    
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'persona_id');
    }
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }
    public function multas()
    {
        return $this->hasManyThrough(MultaPrestamo::class, Prestamo::class, 'persona_id', 'prestamo_id');
    }
    public function inventarios()
    {
        return $this->hasMany(Inventario::class, 'inventario_id');
    }
    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'mantenimiento_id');
    }
}
