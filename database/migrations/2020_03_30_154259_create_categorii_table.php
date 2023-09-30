<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorii', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_parinte')->nullable()->default(0);
            $table->string('denumire',50);
            $table->text('descriere',150);
            $table->string('adr_url',200);
            $table->rememberToken();
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
        Schema::dropIfExists('categorii');
    }
}
