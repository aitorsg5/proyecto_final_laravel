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
        'imagenes_ruta', // Cambiado de 'imagenes' a 'imagenes_ruta'
    ];

    protected $casts = [
        'imagenes_ruta' => 'array', // Ahora maneja las rutas como JSON
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

    // Método para calcular el precio total sumando componentes y aplicando IVA
    public function calcularPrecioTotal()
    {
        return round(
            ($this->kit->precio +
             $this->caja->precio +
             $this->modelo->precio +
             $this->motor->precio +
             $this->precio_basico) * 1.21,
            2
        );
    }

    // Evento para calcular y guardar el precio total antes de guardar el coche
    protected static function booted()
    {
        static::saving(function ($coche) {
            $coche->precio_total = $coche->calcularPrecioTotal();
        });
    }

    // Obtener las URLs de las imágenes desde la columna JSON
    public function getImagenesRutaUrlAttribute()
    {
        return collect($this->imagenes_ruta)->map(fn($ruta) => asset("storage/{$ruta}"));
    }
}