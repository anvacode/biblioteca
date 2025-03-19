<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class DetalleSolicitud extends Model
{
    //
    use HasFactory;
    protected $table = 'detalles_solicitud';
    protected $primaryKey = 'id';
    protected $fillable = ['materiales_id', 'solicitudes_id'];


    public function material()
    {
        return $this->belongsTo(Material::class, 'materiales_id');
    }

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'solicitudes_id');
    }
}
