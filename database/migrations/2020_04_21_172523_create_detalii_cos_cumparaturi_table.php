<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetaliiCosCumparaturiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalii_cos_cumparaturi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cos_cumparaturi_id');
            $table->integer('produs_id');
            $table->integer('cantitate');
            $table->integer('pret');
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
        Schema::dropIfExists('detalii_cos_cumparaturi');
    }
}
