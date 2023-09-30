<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produs extends Model
{
    protected $table = 'produse';

    protected $fillable = ['furnizor_id','id_categorie','cod_produs','denumire','descriere','pret_unitar','imagine','pret_inchiriere_ora',
        'pret_inchiriere_zi','de_inchiriat'];

    public function categorie(){
        return $this->belongsTo("App\Categorie",'id_categorie','id');
    }

    public function furnizor(){
        return $this->belongsTo('App\Furnizor');
    }

    public function specificatie(){
        return $this->hasOne('App\SpecificatieTehnica');
    }

    public function detaliicos(){
        return $this->hasMany('App\DetaliiCosCumparaturi','produs_id','id');
    }

    public function recenzii(){
        return $this->hasMany('App\Recenzie','produs_id','id');
    }

    public function produseinchiriate(){
        return $this->hasMany('App\ProdusInchiriat','produs_id','id');
    }

}
