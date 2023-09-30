<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Furnizor extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table='furnizori';

    public function produse(){
        return $this->hasMany('App\Produs');
    }

    public static function getFurnizoriIdAndEmail(){
        $furnizori = Furnizor::all();
        $data = array();
        foreach ($furnizori as $furnizor){
            $data[] = [
                'id'=>$furnizor->id,
                'email' => $furnizor->email
            ];
        }
        return $data;
    }

    public static function getComenziFurnizor($id){
        $furnizor = Furnizor::where('id',$id)->first();
        $comenziAzi = Comanda::whereDate('created_at', Carbon::today())->get();
        foreach ($comenziAzi as $comanda){
            $furnizor->produse->comanda::where('id',$comanda->id);
        }
    }

}
