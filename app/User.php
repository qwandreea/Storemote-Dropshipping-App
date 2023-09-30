<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    CONST ADMIN = 1;

    use Notifiable;

    protected $table = 'utilizatori';

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $fillable = [
        'calitate', 'nume', 'prenume', 'telefon', 'data_nastere', 'email', 'password', 'imagine','admin'
    ];

    public function coscumparaturi(){
        return $this->hasOne('App\CosCumparaturi','user_id');
    }

    public function recenzii(){
        return $this->hasMany('App\Recenzie','utilizator_id','id');
    }

    public function produseinchiriate(){
        return $this->hasMany('App\ProdusInchiriat','utilizator_id','id');
    }

    public function adrese(){
        return $this->hasMany('App\Adresa','utilizator_id','id')->withTrashed();
    }

    public function intrebari(){
        return $this->hasMany('App\IntrebareForum','id_user');
    }

    public function comenzi(){
        return $this->hasMany('App\Comanda','utilizator_id');
    }

    public function puncteloialitate(){
        return $this->hasOne('App\PuncteLoialitate','utilizator_id','id');
    }

    public function cupoane(){
        return $this->hasMany('App\Cupon','utilizator_id');
    }

    public function eAdmin(){
        return $this->type === self::ADMIN;
    }
}
