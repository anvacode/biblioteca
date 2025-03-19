<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProveedor extends Model
{
    //
    use HasFactory;
    protected $table = 'tipo_proveedores';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre', 'descripcion'];

    public function proveedores()
    {
        return $this->hasMany(Proveedor::class, 'tipoProveedores_id');
    }


}
