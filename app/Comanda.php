<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comanda extends Model
{
    protected $table = 'comenzi';

    protected $fillable = ['status','modalitate_plata'];

    public function utilizator(){
        return $this->belongsTo('App\User');
    }

    public function adresa(){
        return $this->belongsTo('App\Adresa','adresa_id');
    }

    public function tranzactie(){
        return $this->hasOne('App\Tranzactie','nr_comanda','nr_comanda');
    }

    public function produseinchiriate(){
        return $this->hasMany('App\ProdusInchiriat');
    }

    public function produsecos(){
        return $this->hasMany('App\DetaliiCosCumparaturi');
    }

}
