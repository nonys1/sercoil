<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObreroCostoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obrero_costo', function (Blueprint $table) {
            $table->increments('ID_OC');
            $table->integer('ID_VEN');
            $table->integer('MTS2_OC');
            $table->integer('TOT_OC');
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
        Schema::dropIfExists('obrero_costo');
    }
}
