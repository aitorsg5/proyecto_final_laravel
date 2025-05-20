<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coche extends Model
{
    protected $fillable = [
        'nombre',
        'kit_id',
        'caja_id',
        'modelo_id',
        'motor_id',
        'precio_basico',
        'precio_total',
        'imagenes', // <- ¡Importante! Añadido para poder guardar imágenes
    ];

    protected $casts = [
        'imagenes' => 'array', // Para que el campo JSON se maneje como array en PHP
    ];

    // Relaciones
    public function kit()
    {
        return $this->belongsTo(Kit::class);
    }

    public function caja()
    {
        return $this->belongsTo(Caja::class);
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }

    public function motor()
    {
        return $this->belongsTo(Motor::class);
    }

    // Calcula el precio con IVA automáticamente al crear o actualizar
    protected static function booted()
    {
        static::saving(function ($coche) {
            if (!is_null($coche->precio_basico)) {
                $coche->precio_total = round($coche->precio_basico * 1.21, 2);
            }
        });
    }
}
