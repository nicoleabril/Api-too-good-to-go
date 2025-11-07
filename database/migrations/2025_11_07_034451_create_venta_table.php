<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->bigIncrements('id_venta'); // clave primaria

            // Relaciones
            $table->unsignedBigInteger('id_reserva')->nullable();
            $table->unsignedBigInteger('id_negocio');
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('id_cliente');

            // Datos de la venta
            $table->string('tipo_producto', 100)->nullable();
            $table->integer('cantidad')->default(1);
            $table->timestamp('fecha_venta')->useCurrent();

            // Definición de llaves foráneas
            $table->foreign('id_reserva')
                  ->references('id_reserva')
                  ->on('reserva')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->foreign('id_negocio')
                  ->references('id_negocio')
                  ->on('negocio')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_producto')
                  ->references('id_producto')
                  ->on('producto')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('id_cliente')
                  ->references('id_cliente')
                  ->on('cliente')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venta');
    }
};
