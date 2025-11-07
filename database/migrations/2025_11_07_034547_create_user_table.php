<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->bigIncrements('id_usuario'); // clave primaria

            // Campos principales
            $table->string('email', 150)->unique();
            $table->string('contrasenia');
            $table->string('telefono', 20)->nullable();
            $table->float('posicion_x')->nullable();
            $table->float('posicion_y')->nullable();
            $table->timestamp('fecha_registro')->useCurrent();
            $table->string('tipo_usuario', 50)->default('cliente');

            // Campo opcional si usas autenticación con token o recordar sesión
            $table->rememberToken();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
