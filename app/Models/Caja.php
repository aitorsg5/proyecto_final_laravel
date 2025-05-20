<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $table = 'cajas'; // Bien, ya que tu tabla se llama 'cajas'

    protected $fillable = [
        'tipo',
        'traccion',
        'precio',
    ]; // Muy importante para evitar errores con asignación masiva
}
