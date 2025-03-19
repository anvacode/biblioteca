<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estante extends Model
{
  use HasFactory;

  protected $table = 'estantes';
  protected $primaryKey = 'id';

  protected $fillable = [
  'section',
  'shelf_number',
  ];

  public function materiales()
  {
    return $this ->hasMany(Material::class, 'estante_id');
  }
}
