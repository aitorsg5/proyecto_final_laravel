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
        Schema::create('motores', function (Blueprint $table) {
            $table->id();
            $table->string('motor');
            $table->string('combustible');
            $table->decimal('precio', 10, 2);
            $table->boolean('turbo')->default(false);
            $table->integer('cc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motores');
    }
};
