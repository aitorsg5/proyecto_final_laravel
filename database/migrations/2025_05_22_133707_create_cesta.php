<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cesta', function (Blueprint $table) {
            $table->id(); // ID de la cesta
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Usuario que tiene la cesta
            $table->foreignId('coche_id')->constrained('coches')->onDelete('cascade');
             $table->foreignId('kit_id')->constrained('kits')->onDelete('cascade');
            $table->foreignId('caja_id')->constrained('cajas')->onDelete('cascade');
            $table->foreignId('modelo_id')->constrained('modelos')->onDelete('cascade');
            $table->foreignId('motor_id')->constrained('motores')->onDelete('cascade');
            $table->enum('estado', ['pendiente', 'confirmado', 'cancelado'])->default('pendiente');
            $table->decimal('precio_total', 10, 2); // Precio total del coche configurado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cesta');
    }
};