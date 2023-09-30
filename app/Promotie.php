<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotie extends Model
{
   protected $table = 'promotii_cms';

   protected $fillable = ['banner','titlu','mesaj_promotie'];
}
