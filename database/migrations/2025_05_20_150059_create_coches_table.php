<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coches', function (Blueprint $table) {
            $table->id();

            // Relaciones (foreign keys)
$table->string('nombre', 255);

            $table->foreignId('kit_id')->constrained('kits')->onDelete('cascade');
            $table->foreignId('caja_id')->constrained('cajas')->onDelete('cascade');
            $table->foreignId('modelo_id')->constrained('modelos')->onDelete('cascade');
            $table->foreignId('motor_id')->constrained('motores')->onDelete('cascade');

            // Precios
            $table->decimal('precio_basico', 10, 2);
$table->decimal('precio_total', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coches');
    }
};
