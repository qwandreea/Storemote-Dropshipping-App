<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CosCumparaturi;
use App\User;
use App\DetaliiCosCumparaturi;
use App\Produs;
use App\Taxa;
use App\Regiune;
use App\ProdusInchiriat;
use Illuminate\Support\Facades\Session;


class CosCumparaturiController extends Controller
{

    public function adaugaInCos(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            //verificare existenta id sesiune si setare
            $id_sesiune = Session::get('id_sesiune');
            if (!isset($id_sesiune)) {
                $id_sesiune = str_random(40);
                Session::put('id_sesiune', $id_sesiune);
            }

            $verificaCosSesiune = CosCumparaturi::where(['id_sesiune' => $id_sesiune])->get();
            $stocMax = Produs::where('id',$data['id_produs'])->first()->specificatie->stoc;

            //daca utilizatorul nu are cos
            if ($verificaCosSesiune->isEmpty()) {
                $cosCumparaturi = new CosCumparaturi();
                $cosCumparaturi->id_sesiune = $id_sesiune;
                $cosCumparaturi->save();
                $detaliiCos = new DetaliiCosCumparaturi;
                $detaliiCos->cos_cumparaturi_id = $cosCumparaturi->id;
                $detaliiCos->produs_id = $data['id_produs'];
                $detaliiCos->cantitate = $data['cantitate'];
                $detaliiCos->pret = $data['pret_produs'];
                $detaliiCos->save();
                return redirect()->back();

            } else { //utilizatorul are cos si se creeaza detalii noi
                $id = CosCumparaturi::select('id')->where('id_sesiune', $id_sesiune)->first();
                $cantitateUpdate = DetaliiCosCumparaturi::where('cos_cumparaturi_id', $id->id)
                    ->where('produs_id', $data['id_produs'])
                    ->first();
                if (!empty($cantitateUpdate)) {
                   if($cantitateUpdate->cantitate < $stocMax){
                       if ($cantitateUpdate->produs_id == $data['id_produs']) {
                           $count = $cantitateUpdate->cantitate + $data['cantitate'];
                           $cantitateUpdate->update([
                               'cantitate' => $count
                           ]);
                           return redirect()->back();
                       }
                   }else{
                       return redirect()->back()->with('eroare','Stoc indisponibil');
                   }

                } else {
                    $detaliiCos = new DetaliiCosCumparaturi;
                    $detaliiCos->cos_cumparaturi_id = $id->id;
                    $detaliiCos->produs_id = $data['id_produs'];
                    $detaliiCos->cantitate = $data['cantitate'];
                    $detaliiCos->pret = $data['pret_produs'];
                    $detaliiCos->save();
                    return redirect()->back();
                }
            }
        }
    }

    public function cosDeCumparaturi()
    {

        $produse = null;
        $cantitati = null;
        $detaliiCos = null;

        $cosCumparaturi = CosCumparaturi::where(['id_sesiune' => Session::get('id_sesiune')])->first();
        $nrElementeCos = app('App\Http\Controllers\Controller')->nrElementeCos();

        if (!empty($cosCumparaturi)) {
            $detaliiCos = DetaliiCosCumparaturi::where(['cos_cumparaturi_id' => $cosCumparaturi->id])->get();
            if($nrElementeCos === 0){
                $mesaj = 'Cosul dumneavoastra este gol';
                return view('layouts.storeLayout.cos-cumparaturi.cos')->with(compact('mesaj','produse','cantitati'));
            }else{
                $produse = array();
                $cantitati = array();
                $inchiriate = array();
                foreach ($detaliiCos as $cos) {
                    $produse[] = Produs::where(['id' => $cos->produs_id])->first();
                    $cantitati[] = $cos->cantitate;
                }
                if(!empty($cosCumparaturi->produseInchiriate)){
                    foreach ($cosCumparaturi->produseInchiriate as $inchiriat){
                        $inchiriate[] = $inchiriat;
                    }
                }
                return view('layouts.storeLayout.cos-cumparaturi.cos')->with(compact('produse', 'cantitati','inchiriate','cosCumparaturi'));
            }
        } else{
            $mesaj = 'Cosul dumneavoastra este gol';
            return view('layouts.storeLayout.cos-cumparaturi.cos')->with(compact('mesaj','produse','cantitati','inchiriate'));
        }

    }

    public function stergeProdusCos($id = null)
    {
        $count = Produs::where('id', $id)->count();
        if ($count == 0) {
            return view('layouts.storeLayout.404');
        }

        $cosCumparaturiCurent = CosCumparaturi::where(['id_sesiune' => Session::get('id_sesiune')])->first();
        $inregistrareDeSters = DetaliiCosCumparaturi::where('cos_cumparaturi_id', $cosCumparaturiCurent->id)
            ->where('produs_id', $id)->first();
        $inregistrareDeSters->delete();

        return redirect()->back()->with('modificare_cu_succes', 'Produsul a fost sters din cos');

    }

    public function stergeProdusInchiriatCos($id = null){
        $count = ProdusInchiriat::where('id', $id)->count();
        if ($count == 0) {
            return view('layouts.storeLayout.404');
        }

        $cosCumparaturiCurent = CosCumparaturi::where(['id_sesiune' => Session::get('id_sesiune')])->first();
        $inregistrareDeSters = ProdusInchiriat::where('cos_cumparaturi_id', $cosCumparaturiCurent->id)->first();
        $inregistrareDeSters->cos_cumparaturi_id = 0;
        $inregistrareDeSters->save();

        return redirect()->back()->with('modificare_cu_succes', 'Produsul a fost sters din cos');
    }

    public function adaugaCantitate($id = null)
    {

        $count = Produs::where('id', $id)->count();
        if ($count == 0) {
            return view('layouts.storeLayout.404');
        }

        $stocMax = Produs::where('id', $id)->first()->specificatie->stoc;

        $cosCumparaturiCurent = CosCumparaturi::where(['id_sesiune' => Session::get('id_sesiune')])->first();
        $inregistrareDeModificat = DetaliiCosCumparaturi::where('cos_cumparaturi_id', $cosCumparaturiCurent->id)
            ->where('produs_id', $id)->first();

        if ($inregistrareDeModificat->cantitate < $stocMax || $stocMax === null) {
            $inregistrareDeModificat->increment('cantitate');
            return redirect()->back();
        } else {
            return redirect()->back()->with('eroare', 'Stoc insuficient');
        }


    }

    public function stergeCantitate($id = null)
    {
        $count = Produs::where('id', $id)->count();
        if ($count == 0) {
            return view('layouts.storeLayout.404');
        }
        $cosCumparaturiCurent = CosCumparaturi::where(['id_sesiune' => Session::get('id_sesiune')])->first();
        $inregistrareDeModificat = DetaliiCosCumparaturi::where('cos_cumparaturi_id', $cosCumparaturiCurent->id)
            ->where('produs_id', $id)->first();
        $inregistrareDeModificat->decrement('cantitate');
        return redirect()->back();
    }

}
