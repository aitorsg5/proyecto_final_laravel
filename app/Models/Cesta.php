<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cesta extends Model
{
    use HasFactory;
  protected $table = 'cesta'; // Cambia a plural si es necesario

    protected $fillable = [
        'user_id',
        'coche_id',
        'kit_id',
        'caja_id',
        'modelo_id',
        'motor_id',
        'precio_total',
    ];

    protected $casts = [
        'componentes' => 'array', // Permite manejar los componentes como un array
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el coche
    public function coche()
    {
        return $this->belongsTo(Coche::class);
    }

    // Relaciones con los componentes del coche
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
}
