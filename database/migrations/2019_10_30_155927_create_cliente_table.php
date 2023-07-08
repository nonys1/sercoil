<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->increments('ID_CLI');
            $table->integer('CI_CLI');
            $table->string('EXP_CLI');
            $table->string('NOM_CLI');
            $table->string('PAT_CLI');
            $table->string('MAT_CLI');
            $table->date('FEC_NAC')->nullable();
            $table->string('DIR_CLI')->nullable();
            $table->string('TEL_CLI')->nullable();
            $table->string('EMAIL_CLI')->nullable();
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
        Schema::dropIfExists('cliente');
    }
}
