<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialAutor extends Model
{
  use HasFactory;

  protected $table = 'autores';
  protected $primaryKey = 'id';

  protected $fillable = [
  'nombre',
  ];

  public function materiales_autores()
  {
    return $this ->belonsTo(Autor::class);
  }
  public function materiales()
  {
    return $this ->belonsTo(Material::class);
  }
}
