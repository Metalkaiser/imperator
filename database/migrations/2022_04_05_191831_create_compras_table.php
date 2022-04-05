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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->integer('producto_id');
            $table->integer('defectuosos')->default(0);
            $table->float('precio', 4, 2);
            $table->integer('provider_id');   //Proveedor
            $table->integer('carrier_id');     //Empresa de envíos en Miami
            $table->float('costo_envio', 4, 2);
            $table->float('total', 5, 2);
            $table->string('status');           //Estado de la compra
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
        Schema::dropIfExists('compras');
    }
};
