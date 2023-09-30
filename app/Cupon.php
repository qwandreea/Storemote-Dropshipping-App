<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PuncteLoialitate;

class Cupon extends Model
{
    protected $table = 'cupoane';
    protected $keyType = 'string';
    protected $primaryKey = 'cod_cupon';
    public $incrementing = false;
    protected $fillable = ['aplicat'];


    public function utilizator(){
        return $this->belongsTo('App\User');
    }

    public static function randomString($dim){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $dim; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function genereazaCupon($id){
        $puncte = PuncteLoialitate::where('id',$id)->first();
        $nr_puncte = $puncte->nr_puncte;
        if($nr_puncte > 100 && $nr_puncte <200){
            $puncte->nr_puncte -=100;
            $puncte->save();
            $cupon = new Cupon;
            $cupon->cod_cupon = self::randomString(6);
            $cupon->utilizator_id = $puncte->utilizator_id;
            $cupon->tip_cupon = 'procent';
            $cupon->valoare = 5;
            $cupon->aplicat = false;
            $cupon->save();
        }else if ($nr_puncte > 200 && $nr_puncte<500){
            $puncte->nr_puncte -=300;
            $puncte->save();
            $cupon = new Cupon;
            $cupon->cod_cupon = self::randomString(6);
            $cupon->utilizator_id = $puncte->utilizator_id;
            $cupon->tip_cupon = 'procent';
            $cupon->valoare = 10;
            $cupon->aplicat = false;
            $cupon->save();
        }else if ( $nr_puncte>500){
            $puncte->nr_puncte=0;
            $puncte->save();
            $cupon = new Cupon;
            $cupon->cod_cupon = self::randomString(6);
            $cupon->utilizator_id = $puncte->utilizator_id;
            $cupon->tip_cupon = 'procent';
            $cupon->valoare = 30;
            $cupon->aplicat = false;
            $cupon->save();
        }
    }
}
