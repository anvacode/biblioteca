<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clasificacion extends Model
{
    use HasFactory;

    protected $table = 'clasificacion';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre' => $this->faker->word,
        'descripcion' => $this->faker->sentence,
        'estado' => '1',
        'registrado_por' => \App\Models\User::factory()
    ];

    public function clasificacion()
    {
        return $this->belongsToMany('Clasificacion::class');
    }
}
