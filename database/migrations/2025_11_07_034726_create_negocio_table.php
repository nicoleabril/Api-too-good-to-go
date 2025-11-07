<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('negocio', function (Blueprint $table) {
            $table->bigIncrements('id_negocio'); // Clave primaria

            // Relación opcional con categoría
            $table->unsignedBigInteger('id_categoria')->nullable();

            // Campos principales
            $table->string('nombre_negocio', 150);
            $table->text('descripcion')->nullable();
            $table->time('horario_apertura')->nullable();
            $table->time('horario_cierre')->nullable();
            $table->string('horario_oferta', 100)->nullable();
            $table->string('logotipo')->nullable();
            $table->string('imagen_referencial')->nullable();
            $table->decimal('posicion_x', 10, 6)->nullable();
            $table->decimal('posicion_y', 10, 6)->nullable();

            // 🔗 Si tienes la tabla 'categoria', puedes activar la relación:
            // $table->foreign('id_categoria')->references('id_categoria')->on('categoria')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('negocio');
    }
};
