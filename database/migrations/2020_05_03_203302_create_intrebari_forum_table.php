<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntrebariForumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intrebari_forum', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_parinte');
            $table->integer('id_user')->default(0);
            $table->string('titlu')->nullable();
            $table->text('continut');
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
        Schema::dropIfExists('intrebari_forum');
    }
}
