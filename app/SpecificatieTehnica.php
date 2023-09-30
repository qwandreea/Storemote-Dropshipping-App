<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecificatieTehnica extends Model
{
    protected $table = 'specificatii_tehnice';

    public function produs(){
        return $this->belongsTo("App\Produs");
    }

    protected $fillable = [
        'produs_id', 'greutate' ,'unitate_masura_greutate','lungime','latime','inaltime','unitate_masura','culoare', 'material', 'stoc'
    ];
}
