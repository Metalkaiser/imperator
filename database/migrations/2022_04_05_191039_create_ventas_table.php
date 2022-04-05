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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cliente');
            $table->string('ciudad_cliente');
            $table->string('telefono_cliente')->nullable();
            $table->integer('plataforma_id');   //Plataforma desde donde el cliente contactó
            $table->boolean('comision_ml');     //Comisión de mercadolibre
            $table->integer('promo_id')->nullable();        //ID de promoción si aplica
            $table->string('status');           //Estado de la venta
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
        Schema::dropIfExists('ventas');
    }
};
