<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdusInchiriat extends Model
{
    protected $table = 'produse_inchiriate';

    protected $fillable = ['produs_id','utilizator_id','data_inceput','data_sfarsit','tip','cantitate','subtotal','status'];

    public function utilizator(){
        return $this->belongsTo('App\User');
    }

    public function produs(){
        return $this->belongsTo('App\Produs');
    }

    public function cosCumparaturi(){
        return $this->belongsTo('App\CosCumparaturi');
    }

    public function comanda(){
        return $this->belongsTo('App\Comanda','comanda_id');
    }
}
