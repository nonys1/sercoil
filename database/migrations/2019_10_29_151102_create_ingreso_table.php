<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso', function (Blueprint $table) {
            $table->increments('ID_ING');
            $table->integer('ID_USU');
            $table->integer('CANT_ING');
            $table->integer('TOT_ING');
            $table->date('FEC_ING');
            $table->integer('ID_PRO');
            $table->string('TIP_COM');
            $table->string('SER_ING');
            $table->string('COR_ING');
            $table->string('IGV_ING');
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
        Schema::dropIfExists('ingreso');
    }
}
