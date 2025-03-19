<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    //
    use HasFactory;
    protected $table = 'solicitudes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fechaSolicitud',
        'estado',
        'persona_id',
        'proveedores_id'];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedores_id');
    }

    public function ordenesCompra()
    {
        return $this->hasMany(OrdenCompra::class, 'solicitudes_id');
    }
}
