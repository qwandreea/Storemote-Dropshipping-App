<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecenziiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recenzii', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('utilizator_id');
            $table->integer('produs_id');
            $table->string('titlu');
            $table->integer('nota');
            $table->text('comentariu');
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
        Schema::dropIfExists('recenzii');
    }
}
