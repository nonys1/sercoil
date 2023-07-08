<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentaCotizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venta_cotizacion', function (Blueprint $table) {
            $table->increments('ID_VC');
            $table->integer('ID_VEN');
            $table->double('MTS_VC');
            $table->integer('ID_PRO');
            $table->double('RES_VC');
            $table->integer('CANT_VC');
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
        Schema::dropIfExists('venta_cotizacion');
    }
}
