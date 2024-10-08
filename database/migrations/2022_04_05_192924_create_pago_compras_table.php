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
        Schema::create('pago_compras', function (Blueprint $table) {
            $table->id();
            $table->integer('compra_id');
            $table->string('tipo');             //Plataforma de pago usada
            $table->string('referencia');       //Código de referencia de pago
            $table->string('monto');
            $table->string('moneda');
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
        Schema::dropIfExists('pago_compras');
    }
};
