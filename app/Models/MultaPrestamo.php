<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultaPrestamo extends Model
{
    use HasFactory;

    protected $table = 'multa_prestamo';
    protected $primaryKey = 'id';
    protected $fillable = [
        'prestamo_id',
        'fecha_multa',
        'valor',
        'multa'
    ];

    
    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'prestamo_id');
    }
    public function multa()
    {
        return $this->belongsTo(Multa::class, 'multa_id');
    }
}

