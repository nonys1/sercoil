<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_detalle', function (Blueprint $table) {
            $table->increments('ID_ID');
            $table->integer('ID_ING');
            $table->integer('ID_PRO');
            $table->double('PRE_COM');
            $table->double('PRE_VEN');
            $table->date('FEC_PROD');
            $table->date('FEC_VENC');
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
        Schema::dropIfExists('ingreso_detalle');
    }
}
