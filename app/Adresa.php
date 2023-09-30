<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
class Adresa extends Model
{
    use SoftDeletes;
    protected $table = 'adrese';
    protected $dates = ['deleted_at'];

    protected $fillable = ['utilizator_id','adresa','cod_postal','oras','regiune'];

    public function utilizator(){
        return $this->belongsTo('App\User');
    }

    public function comenzi(){
        return $this->hasMany('App\Comanda');
    }
}
