<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProduseInchiriateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produse_inchiriate', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produs_id');
            $table->integer('utilizator_id');
            $table->dateTime('data_inceput');
            $table->dateTime('data_sfarsit');
            $table->enum('tip',['zi','ora']);
            $table->integer('cantitate');
            $table->float('subtotal');
            $table->enum('status',['In asteptare','Acceptat','Respins']);
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
        Schema::dropIfExists('produse_inchiriate');
    }
}
