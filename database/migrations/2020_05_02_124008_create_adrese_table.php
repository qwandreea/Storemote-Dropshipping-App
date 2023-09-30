<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdreseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adrese', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('utilizator_id');
            $table->string('adresa');
            $table->string('cod_postal',6);
            $table->string('oras');
            $table->string('regiune');
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
        Schema::dropIfExists('adrese');
    }
}
