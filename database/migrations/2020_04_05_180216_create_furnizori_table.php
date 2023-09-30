<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFurnizoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('furnizori', function (Blueprint $table) {
            $table->increments('id');
            $table->string('denumire_furnizor',30);
            $table->string('persoana_contact',20)->nullable();
            $table->string('email');
            $table->string('telefon',10);
            $table->string('adresa',30)->nullable();
            $table->string('oras',20)->nullable();
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
        Schema::dropIfExists('furnizori');
    }
}
