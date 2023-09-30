<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformatieContact extends Model
{
    protected $table = 'contact__c_m_s';

    protected $fillable = ['adresa' , 'email' , 'telefon' , 'skype'];
}
