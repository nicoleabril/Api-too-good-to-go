<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->bigIncrements('id_producto'); // clave primaria

            // Relaciones
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('id_negocio');

            // Campos del producto
            $table->string('nombre_producto', 150);
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->decimal('precio', 10, 2);
            $table->timestamp('fecha_creacion')->useCurrent();

            // Definición de llaves foráneas
            $table->foreign('id_categoria')
                  ->references('id_categoria')
                  ->on('categoria')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_negocio')
                  ->references('id_negocio')
                  ->on('negocio')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
