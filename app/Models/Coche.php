<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coche extends Model
{
    protected $fillable = [
        'nombre', 'kit_id', 'caja_id', 'modelo_id', 'motor_id', 'precio_basico', 'precio_total',
    ];

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

    protected static function booted()
    {
        static::creating(function ($coche) {
            if (isset($coche->precio_basico)) {
                $coche->precio_total = round($coche->precio_basico * 1.21, 2); // aplica 21% IVA y redondea a 2 decimales
            }
        });

        static::updating(function ($coche) {
            if (isset($coche->precio_basico)) {
                $coche->precio_total = round($coche->precio_basico * 1.21, 2);
            }
        });
    }
}
