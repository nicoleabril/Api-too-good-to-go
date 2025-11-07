<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentario', function (Blueprint $table) {
            $table->bigIncrements('id_comentario'); // Clave primaria
            $table->unsignedBigInteger('id_negocio'); // Relación con negocio
            $table->unsignedBigInteger('id_cliente'); // Relación con cliente
            $table->text('descripcion'); // Texto del comentario
            $table->timestamp('fecha_creacion')->useCurrent(); // Fecha automática

            // Relaciones
            $table->foreign('id_negocio')->references('id_negocio')->on('negocio')->onDelete('cascade');
            $table->foreign('id_cliente')->references('id_cliente')->on('cliente')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentario');
    }
};
