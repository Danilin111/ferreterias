<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('factura_producto', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->foreignId('factura_id')->constrained('facturas')->onDelete('cascade'); // Relación con facturas
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade'); // Relación con productos
            $table->integer('cantidad'); // Cantidad de productos en la factura
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura_producto');
    }
};
