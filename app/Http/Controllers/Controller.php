<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Categorie;
use App\Produs;
use App\Furnizor;
use App\SpecificatieTehnica;
use App\CosCumparaturi;
use App\DetaliiCosCumparaturi;
use App\InformatieContact;
use App\Promotie;
use App\Oras;
use App\Regiune;
use App\ProdusInchiriat;
use App\Adresa;
use App\IntrebareForum;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function categoriiPrincipale(){
        $categoriiPrincipale = Categorie::where(['id_parinte'=>0])->get();
        $categoriiPrincipale = json_decode(json_encode($categoriiPrincipale));
        return $categoriiPrincipale;
    }

    public static function subcategoriiCategorii(){
        $subcategorie = Categorie::all();
        $subcategorie = json_decode(json_encode($subcategorie));
        return $subcategorie;
    }

    public static function produseAll(){
        $produse = Produs::orderBy('id', 'DESC')->get();
        $produse = json_decode(json_encode($produse));
        return $produse;
    }

    public static function produseMostra(){
        $produseMostra=Produs::inRandomOrder()->limit(8)->get();
        $produseMostra = json_decode(json_encode($produseMostra));
        return $produseMostra;

    }

    public static function furnizoriAll(){
        $furnizori = Furnizor::all();
        $furnizori = json_decode(json_encode($furnizori));
        return $furnizori;
    }

    public static function specificatiiAll(){
        $specificatii = SpecificatieTehnica::all();
        $specificatii = json_decode(json_encode($specificatii));
        return $specificatii;
    }

    public static function nrElementeCos(){
        $nrElemCos=0;
        $cosCumparaturi = CosCumparaturi::where(['id_sesiune'=>Session::get('id_sesiune')])->first();
        if(!empty($cosCumparaturi->detaliiCos)){
             foreach ($cosCumparaturi->detaliiCos as $cantitateCos){
                 $nrElemCos+=$cantitateCos->cantitate;
             }
        }
        if(!empty($cosCumparaturi->produseInchiriate)){
            foreach ($cosCumparaturi->produseInchiriate as $cantitateInc){
                $nrElemCos+=$cantitateInc->cantitate;
            }
        }
        return $nrElemCos;
    }

    public static function infoContact(){
        $informatii = InformatieContact::first();
        return $informatii;
    }

    public static function promotii(){
        $promotii = Promotie::all();
        $promotii = json_decode(json_encode($promotii));
        return $promotii;
    }

    public static function produseDeInchiriat(){
        $produse = Produs::where('de_inchiriat',1)->get();
        $produse = json_decode(json_encode($produse));
        return $produse;
    }

    public static function getAdresaExistenta(){
        $client = Auth::user();
        $adrese = null;
        if($client){
            if($client->adrese->count() === 0){
                $adrese = null;
            }else{
                $adrese = Adresa::where('utilizator_id',$client->id)->get();
                $adrese = json_decode(json_encode($adrese));
            }
        }

        return $adrese;
    }

    public static function getOras(){
        $orase = Oras::all();
        $orase = json_decode(json_encode($orase));
        return $orase;
    }

    public static function getIntrebariForumInterval(){
        $intrebari = IntrebareForum::where('id_parinte',0)
            ->orderBy('created_at', 'DESC')
            ->get();
        // ->whereBetween('created_at',[Carbon::today()->subDays( 3 ),Carbon::today()])
        return $intrebari;
    }

    public static function creeazaPdf($comanda){
            $pdf = PDF::loadView('mail',["nr"=>$comanda->count()])->setPaper('a4', 'landscape');
            return $pdf;
            $to_email = "mogosandreea995@yahoo.com";
            $data = array("name" => "Andreea Mogos", "body" => "Test email");
            Mail::send('mail', $data, function ($message) use ($to_email) {
            $message->to($to_email)
                ->subject('Test mail')
            ->attachData($pdf, 'invoice.pdf');
        });
    }

    public static function getDaysBetweenTwoDates($start,$end)
    {

        $interval = round((strtotime($end) - strtotime($start))/86400, 1);
        return $interval;
    }
}
