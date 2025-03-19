<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class OrdenCompra extends Model
{
    //
    use HasFactory;
    protected $table = 'ordenes_compra';
    protected $primaryKey = 'id';
    protected $fillable = [
        'solicitudes_id', 
        'fecha_compra', 
        'total_pagado'
    ];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'solicitudes_id');
    }
}
