<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->bigIncrements('id_cliente'); // clave primaria personalizada
            $table->string('nombre', 100);
            $table->string('foto_perfil')->nullable();
            $table->float('posicion_x')->nullable();
            $table->float('posicion_y')->nullable();
            $table->timestamps(); // si deseas conservar created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
