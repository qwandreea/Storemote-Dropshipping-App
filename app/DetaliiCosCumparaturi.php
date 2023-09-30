<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetaliiCosCumparaturi extends Model
{
    protected $table = 'detalii_cos_cumparaturi';

    protected $fillable = ['cos_cumparaturi_id', 'produs_id', 'cantitate', 'pret'];

    public function coscumparaturi(){
        return $this->belongsTo('App\CosCumparaturi','cos_cumparaturi_id','id');
    }

    public function produs(){
        return $this->belongsTo('App\Produs');
    }
}
