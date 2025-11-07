<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reserva', function (Blueprint $table) {
            $table->bigIncrements('id_reserva');
            $table->unsignedBigInteger('id_negocio');
            $table->unsignedBigInteger('id_cliente');
            $table->string('metodo_pago', 100)->nullable();
            $table->date('fecha');
            $table->time('hora_minima');
            $table->time('hora_maxima');
            $table->string('estado', 50)->default('pendiente');
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('correo_electronico', 150);
            $table->string('telefono', 20);

            // Relaciones (foreign keys)
            $table->foreign('id_negocio')
                ->references('id_negocio')
                ->on('negocio')
                ->onDelete('cascade');

            $table->foreign('id_cliente')
                ->references('id_cliente')
                ->on('cliente')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reserva');
    }
};
