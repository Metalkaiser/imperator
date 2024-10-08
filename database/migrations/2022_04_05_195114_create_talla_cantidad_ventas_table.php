<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talla_cantidad_ventas', function (Blueprint $table) {
            $table->id();
            $table->integer('venta_id');
            $table->integer('producto_id');
            $table->string('talla');
            $table->integer('cantidad');
            $table->string('precio');           //Precio de venta por unidad
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talla_cantidad_ventas');
    }
};
