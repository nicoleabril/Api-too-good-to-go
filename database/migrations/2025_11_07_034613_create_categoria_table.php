<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categoria', function (Blueprint $table) {
            $table->bigIncrements('id_categoria'); // Clave primaria

            // Relación con negocio
            $table->unsignedBigInteger('id_negocio');

            // Atributos principales
            $table->string('nombre_categoria', 100);
            $table->text('descripcion')->nullable();
            $table->boolean('habilitado')->default(true);
            $table->string('imagen_categoria')->nullable();
            $table->timestamp('fecha_creacion')->useCurrent();

            // 🔗 Clave foránea opcional (solo si ya tienes tabla 'negocio')
            $table->foreign('id_negocio')->references('id_negocio')->on('negocio')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categoria');
    }
};
