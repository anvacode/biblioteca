<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
  use HasFactory;

  protected $table = 'autores';
  protected $primaryKey = 'id';

  protected $fillable = [
  'nombre',
  'apellido',
  'bibliografia',
  ];

  public function materialAutor()
  {
    return $this ->hasMany(MaterialAutor::class, 'autor_id');
  }
}
