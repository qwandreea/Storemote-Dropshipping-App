<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntrebareForum extends Model
{
    protected $table = 'intrebari_forum';

    protected $fillable = ['id_user','titlu','continut'];

    public function utilizator(){
        return $this->belongsTo('App\User','id_user','id');
    }
}
