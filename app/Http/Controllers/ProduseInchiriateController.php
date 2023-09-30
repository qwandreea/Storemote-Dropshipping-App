<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProdusInchiriat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\CosCumparaturi;

class ProduseInchiriateController extends Controller
{
    public function solicita(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $current_user = Auth::user()->id;

            $existence = ProdusInchiriat::where(['produs_id'=>$data['id'],'utilizator_id'=>$current_user])->first();
            if(!empty($existence)){
                return redirect('/solicitarile-mele/'.$current_user)->with('modificare_cu_succes', 'Acest produs a fost deja solicitat pentru inchiriere');
            }else{

                $produs_inchiriat = new ProdusInchiriat;
                $produs_inchiriat->produs_id = $data['id'];
                $produs_inchiriat->utilizator_id = $current_user;
                $produs_inchiriat->data_inceput = $data['dataInceput'];
                $produs_inchiriat->data_sfarsit = $data['dataSfarsit'];
                $produs_inchiriat->tip = $data['select-tip'];
                $produs_inchiriat->cantitate = $data['cantitate'];
                $produs_inchiriat->subtotal = $data['subtotal'];
                $produs_inchiriat->save();
            }
            return redirect('/solicitarile-mele/'.$current_user)->with('modificare_cu_succes', 'Solicitarea a fost inregistrata');
        }
    }

    public function anuleazaSolicitare($id=null){
        $nrProd = ProdusInchiriat::where(['id' => $id])->count();
        if ($nrProd == 0) return view('layouts.storeLayout.404');

        $produs = ProdusInchiriat::where(['id'=>$id])->delete();
        return redirect()->back()->with('modificare_cu_succes','Solicitarea a fost anulata');
    }

    public function adaugaInchiriereComanda($id=null){
        $nrProd = ProdusInchiriat::where(['id' => $id])->count();
        if ($nrProd == 0) return view('layouts.storeLayout.404');
        $produsInchiriat = ProdusInchiriat::where('id',$id)->first();

        $id_sesiune = Session::get('id_sesiune');
        if (!isset($id_sesiune)) {
            $id_sesiune = str_random(40);
            Session::put('id_sesiune', $id_sesiune);
        }

        $cosCumparaturi = CosCumparaturi::where('id_sesiune',$id_sesiune)->first();
        if($cosCumparaturi === null){
            $cosNou = new CosCumparaturi;
            $cosNou->id_sesiune = $id_sesiune;
            $cosNou->save();
            $produsInchiriat->cos_cumparaturi_id = $cosNou->id;
            $produsInchiriat->save();

        }else{
            $produsInchiriat->cos_cumparaturi_id = $cosCumparaturi->id;
            $produsInchiriat->save();
        }
        return redirect()->back();

    }

}
