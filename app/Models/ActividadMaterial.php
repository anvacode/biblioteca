<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'actividad_id',
        'material_id',
        'cantidad'
    ];

    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
