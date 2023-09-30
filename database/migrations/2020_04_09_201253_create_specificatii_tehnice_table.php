<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecificatiiTehniceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specificatii_tehnice', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produs_id');
            $table->string('culoare');
            $table->string('material');
            $table->integer('stoc')->nullable();
            $table->float('greutate');
            $table->string('unitate_masura_greutate');
            $table->float('lungime')->nullable();
            $table->float('latime')->nullable();
            $table->float('inaltime')->nullable();
            $table->string('unitate_masura')->nullable();
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
        Schema::dropIfExists('specificatii_tehnice');
    }
}
