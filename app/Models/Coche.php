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
        'imagenes', // Guardar imágenes
    ];

    protected $casts = [
        'imagenes' => 'array', // Manejo como array en PHP
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
    public function getImagenesUrlAttribute()
{
    return collect($this->imagenes)->map(fn ($imagen) => url("storage/coches/{$imagen}"));
}

}