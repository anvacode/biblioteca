<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
  use HasFactory;

  protected $table = 'materiales';
  protected $primaryKey = 'id';
  
  protected $fillable = [
  'titulo',
  'ISBN',
  'anio',
  'estado',
  'registradoPor',
  'clasificacion_id',
  ];

  public function clasificacion()
  {
    return $this ->belonsTo(Clasificacion::class);
  }
  public function categoria()
  {
    return $this ->belonsTo(Categoria::class);
  }
  public function estante()
  {
    return $this ->belonsTo(Estante::class);
  }
  public function materialAutor()
  {
    return $this ->hasMany(MaterialAutor::class, 'materialAutor_id');
  }
  
  
}
