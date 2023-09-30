<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Produs;

class Categorie extends Model
{
    protected $table = 'categorii';

    public function produse(){
         return $this->hasMany("App\Produs",'id_categorie');
    }
}
