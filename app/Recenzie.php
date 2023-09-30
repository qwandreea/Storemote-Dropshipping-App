<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recenzie extends Model
{
    protected $table = 'recenzii';

    public function utilizator(){
        return $this->belongsTo('App\User');
    }

    public function produs(){
        return $this->belongsTo('App\Produs');
    }

}
