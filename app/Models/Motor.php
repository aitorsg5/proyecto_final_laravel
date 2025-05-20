<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;
    protected $table = 'motores'; // <-- aquí

    protected $fillable = [
        'motor',
        'combustible',
        'precio',
        'turbo',
        'cc',
    ];
}
