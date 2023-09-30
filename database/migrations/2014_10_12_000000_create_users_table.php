<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilizatori', function (Blueprint $table) {
            $table->increments('id');
            $table->string('calitate',3);
            $table->string('nume',30);
            $table->string('prenume',30);
            $table->string('telefon',10);
            $table->date('data_nastere');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('admin')->nullable()->default(0);
            $table->string('imagine')->nullable()->default('default.jpg');
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
        Schema::dropIfExists('utilizatori');
    }
}
