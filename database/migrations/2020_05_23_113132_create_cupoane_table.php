<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateCupoaneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cupoane', function (Blueprint $table) {
            $table->string('cod_cupon',6)->primary();
            $table->integer('utilizator_id');
            $table->enum('tip_cupon',['procent','fix']);
            $table->float('valoare');
            $table->boolean('aplicat');
            $table->date('expira_la')->default(Carbon::now()->addMonths(1));
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
        Schema::dropIfExists('cupoane');
    }
}
