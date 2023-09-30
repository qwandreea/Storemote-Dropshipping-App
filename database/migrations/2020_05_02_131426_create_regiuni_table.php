<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegiuniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regiuni', function (Blueprint $table) {
            $table->integer('id');
           $table->integer('oras_id');
           $table->bigInteger('siruta');
           $table->decimal('longitude');
           $table->decimal('latitude');
           $table->string('name');
           $table->string('region');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regiuni');
    }
}
