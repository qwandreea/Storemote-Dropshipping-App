<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produse', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('furnizor_id');
            $table->integer('id_categorie');
            $table->string('cod_produs',10);
            $table->string('denumire',30);
            $table->text('descriere');
            $table->float('pret_unitar');
            $table->string('imagine');
            $table->float('pret_inchiriere_ora')->nullable();
            $table->float('pret_inchiriere_zi')->nullable();
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
        Schema::dropIfExists('produse');
    }
}
