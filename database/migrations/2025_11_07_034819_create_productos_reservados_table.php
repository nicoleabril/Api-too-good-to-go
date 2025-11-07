<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos_reservados', function (Blueprint $table) {
            $table->bigIncrements('id_producto_reservado');
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_reserva');
            $table->unsignedBigInteger('id_negocio');
            $table->unsignedBigInteger('id_cliente');
            $table->integer('cantidad')->default(1);
            $table->string('tipo_producto', 100)->nullable();

            // Relaciones (foreign keys)
            $table->foreign('id_producto')
                ->references('id_producto')
                ->on('producto')
                ->onDelete('cascade');

            $table->foreign('id_reserva')
                ->references('id_reserva')
                ->on('reserva')
                ->onDelete('cascade');

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
        Schema::dropIfExists('productos_reservados');
    }
};
