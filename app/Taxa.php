<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Oras;

class Taxa extends Model
{
    protected $table = 'taxa_orase';

    protected $fillable = ['oras_id','taxa'];

    public function oras(){
        return $this->belongsTo('App\Oras');
    }
}
