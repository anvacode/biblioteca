<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clasificacion extends Model
{
    use HasFactory;

    protected $table = 'clasificaciones';
    protected $primaryKey = 'id';

    protected $fillable = [
    'nombre',
    'descripcion',
    'estado',
    'registradoPor',
    ];

    public function materiales()
    {
      return $this ->hasMany(Material::class, 'clasificacion_id');
    }
   
}
