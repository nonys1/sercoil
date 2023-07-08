<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venta', function (Blueprint $table) {
            $table->increments('ID_VEN');
            $table->integer('ID_USU');
            $table->date('FEC_VEN');
            $table->integer('ID_CLIE');
            $table->time('HOR_VEN');
            $table->string('TIP_COM_VEN');
            $table->string('SER_VEN');
            $table->string('COR_VEN');
            $table->string('IGV_VEN');
            $table->integer('EST_VEN')->default(0);
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
        Schema::dropIfExists('caja');
    }
}
