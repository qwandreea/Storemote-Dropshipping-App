<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tranzactie extends Model
{
    protected $table = 'tranzactii';

    private function comanda(){
        return $this->belongsTo('App\Comanda','nr_comanda','nr_comanda');
    }
}
