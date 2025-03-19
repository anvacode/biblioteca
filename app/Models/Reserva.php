<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Definición del modelo `Reserva`
class Reserva extends Model
{
    use HasFactory; // Habilita el uso de factories para generar datos de prueba

    // Especifica el nombre de la tabla asociada al modelo
    protected $table = 'reservas';

    // Define los campos que pueden ser asignados masivamente (mass assignment)
    protected $fillable = [
        'fecha_reserva', // Fecha y hora de la reserva
        'estado', // Estado de la reserva (por ejemplo, "pendiente", "confirmada", etc.)
        'personas_id', // ID de la persona asociada a la reserva
        'materiales_id', // ID del material asociado a la reserva
    ];

    /**
     * Relación con el modelo `Persona`.
     * Indica que una reserva pertenece a una persona.
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'personas_id');
    }

    /**
     * Relación con el modelo `Material`.
     * Indica que una reserva pertenece a un material.
     */
    public function material()
    {
        return $this->belongsTo(Material::class, 'materiales_id');
    }
}