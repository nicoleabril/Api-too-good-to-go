<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categoria_negocio', function (Blueprint $table) {
            $table->bigIncrements('id_categoria'); // Clave primaria
            $table->string('nombre', 100); // Nombre de la categoría
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categoria_negocio');
    }
};
