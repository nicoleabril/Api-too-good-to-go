<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oferta', function (Blueprint $table) {
            $table->bigIncrements('id_oferta'); // Clave primaria
            $table->unsignedBigInteger('id_negocio'); // Relación con negocio
            $table->string('nombre_oferta', 255);
            $table->text('descripcion')->nullable();
            $table->string('imagen_oferta', 255)->nullable();
            $table->decimal('precio', 10, 2);
            $table->timestamp('fecha_creacion')->useCurrent();

            // Relación con negocio
            $table->foreign('id_negocio')
                  ->references('id_negocio')
                  ->on('negocio')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oferta');
    }
};
