<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Oras;

class Regiune extends Model
{
   protected $table = 'regiuni';

   public function oras(){
       return $this->belongsTo('App\Oras');
   }
}
