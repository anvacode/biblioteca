<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    //
    use HasFactory;

    protected $table = 'Proveedores';
    protected $primaryKey = 'id';
    protected $fillable = ['tipoProveedores_id', 'nombre', 'contacto', 'email'];

    public function tipoProveedor()
    {
        return $this->belongsTo(TipoProveedor::class, 'tipoProveedores_id');
    }

}
