<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    use HasFactory;

    protected $table = 'editoriales'; // Nombre de la tabla
    protected $fillable = ['nombre', 'direccion', 'telefono']; // Ajusta según los campos de tu tabla
}