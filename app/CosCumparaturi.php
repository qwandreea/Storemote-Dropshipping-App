<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProdusInchiriat;

class CosCumparaturi extends Model
{
    protected $table = 'cos_cumparaturi';

    public function utilizator(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function detaliicos(){
        return $this->hasMany('App\DetaliiCosCumparaturi');
    }

    public function produseInchiriate(){
        return $this->hasMany('App\ProdusInchiriat','cos_cumparaturi_id','id');
    }
}
