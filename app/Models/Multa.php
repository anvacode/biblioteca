<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multa extends Model
{
    use HasFactory;

    protected $table = 'multas'; 
    protected $primaryKey = 'id'; 
    protected $fillable = [
        'total',
        'multaPrestamo_id',
        'persona_id'
    ];

    
    public function multaPrestamos()
    {
        return $this->hasMany(MultaPrestamo::class, 'multa_id');
    }
}

