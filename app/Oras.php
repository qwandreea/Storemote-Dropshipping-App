<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Regiune;
use App\Taxa;

class Oras extends Model
{
    protected $table='orase';

    public function regiuni(){
        return $this->hasMany('App\Regiune','oras_id','id');
    }

    public function taxa(){
        return $this->hasOne('App\Taxa','oras_id','id');
    }
}
