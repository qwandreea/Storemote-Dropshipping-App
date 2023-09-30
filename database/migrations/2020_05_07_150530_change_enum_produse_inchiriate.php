<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEnumProduseInchiriate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `produse_inchiriate` CHANGE `status` `status` ENUM('In asteptare','Acceptat','Respins','Comandat');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `produse_inchiriate` CHANGE `status` `status` ENUM('In asteptare','Acceptat','Respins');");
    }
}
