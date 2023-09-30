<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Cupon;

class PuncteLoialitate extends Model
{
    public $timestamps = false;
    protected $table = 'puncte_loialitate';


    public function utilizator(){
        return $this->belongsTo('App\User');
    }

    public static function priceToFidelityPoints($price){
        if($price>100){
            return floor($price/100);
        }else{
            return 0;
        }
    }

    public static function storePointsToDatabase($amount,$id){
        $puncte = PuncteLoialitate::where('utilizator_id',$id)->first();
       if($puncte){
           $puncte->nr_puncte+=self::priceToFidelityPoints($amount);
           $puncte->save();
       }else{
           $puncte = new PuncteLoialitate;
           $puncte->utilizator_id = $id;
           $puncte->nr_puncte = self::priceToFidelityPoints($amount);
           $puncte->save();
       }
       Cupon::genereazaCupon($puncte->id);
    }

}
