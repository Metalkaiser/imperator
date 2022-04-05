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
        Schema::create('talla_cantidad_compras', function (Blueprint $table) {
            $table->id();
            $table->integer('compra_id');
            $table->integer('producto_id');
            $table->string('talla');
            $table->integer('cantidad');
            $table->integer('defectuosos')->default(0);
            $table->float('precio', 4, 2);
            $table->integer('provider_id');   //Proveedor
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
        Schema::dropIfExists('talla_cantidad_compras');
    }
};
