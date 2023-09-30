<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComenziTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comenzi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nr_comanda',6);
            $table->integer('utilizator_id');
            $table->integer('adresa_id');
            $table->enum('status',['Neaprobata','In procesare','In depozit','Livrata'])->nullable()->default('In procesare');
            $table->string('modalitate_plata');
            $table->float('subtotal');
            $table->float('taxa');
            $table->float('total');
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
        Schema::dropIfExists('comenzi');
    }
}
