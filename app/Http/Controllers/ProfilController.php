<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use View;
use Image;
use App\Produs;
use App\Recenzie;
use App\Adresa;
use App\Regiune;
use App\Oras;
use App\Comanda;
use App\InformatieContact;
use App\DetaliiCosCumparaturi;
use App\ProdusInchiriat;
use App\Cupon;
use App\PuncteLoialitate;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade as PDF;

class ProfilController extends Controller
{
    public function profilUtilizator()
    {
        $profilUtilizator = DB::table('utilizatori')->where('id', Auth::user()->id)->first();
        return view('layouts.profilLayout.profil')->with(compact('profilUtilizator'));
    }

    public function editeazaProfil($id = null, Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'nume' => 'required|string|max:30|regex:/^[a-zA-Z0]+$/',
                'prenume' => 'required|string|max:30|regex:/^[a-zA-Z]+$/u',
                'telefon' => 'regex:/(0)[0-9]{9}/|max:10|min:10',
                'email' => 'required|string|email|max:255',
                'imagine' => 'image|mimes:jpeg,png,jpg|max:2048',
            ], [
                'required' => 'Campul :attribute trebuie completat.',
                'nume.regex' => 'Numele poate conține doar litere, fără spații și diacritice',
                'prenume.regex' => 'Prenumele poate conține doar litere, fără spații și diacritice',
                'telefon.regex' => 'Numarul de telefon e invalid.',
                'telefon.numeric' => 'Campul :attribute trebuie sa contina doar numere.',
                'telefon.max' => 'Campul :attribute trebuie sa contina 10 cifre',
                'max' => 'Campul :attribute trebuie sa contina maxim 30 de caractere.',
                'email' => 'Campul :attribute nu respecta formatul standard.',
                'unique' => 'Adresa de email exista deja.',
                'confirmed' => 'Cele doua parole nu corespund.',
                'imagine.mimes' => 'Avatarul accepta doar extensii jpeg,jpg,png',
                'image' => 'Fisierul trebuie sa fie o imagine.'
            ]);

            $data = $request->all();;
            $user = Auth::user()::where('id', $id)->first();

            $user->update(['nume' => $data['nume'], 'prenume' => $data['prenume'], 'telefon' => $data['telefon'], 'data_nastere' => $data['data'], 'email' => $data['email']]);

            if ($request->hasFile('imagine')) {
                $imagine = Input::file('imagine');
                if ($imagine->isValid()) {
                    $numefisier = time() . '.' . $imagine->getClientOriginalExtension();
                    Image::make($imagine)->resize(300, 300)->save(public_path('uploads/avatar/' . $numefisier));
                    $user->imagine = $numefisier;
                    $user->save();
                }
            }

            if ($data['password'] && $data['password_confirmation']) {
                $parolaCurenta = Auth::User()->getAuthPassword();

                $this->validate($request, [
                    'password' => 'string|min:6|confirmed',
                ], [
                    'password.min' => 'Parola trebuie sa contina mimim 6 caractere.',
                ]);

                if (Hash::check($data['password'], $parolaCurenta)) {
                    $error = array('current-password' => 'Aceasta parola este deja setata');
                    return redirect()->back()->with('error', 'Aceasta parola este deja setata.');

                } else {
                    $user->update(['password' => Hash::make($data['password'])]);
                }
            }
            return redirect()->back()->with('succes', 'Datele dumneavoastra au fost actualizate');
        }
    }

    public function adaugaRecenzie($id = null, Request $request)
    {
        $data = $request->all();

        $count = Produs::where('id', $id)->count();
        if ($count == 0) {
            return view('layouts.storeLayout.404');
        }

        if ($request->isMethod('post')) {
            $recenzie = new Recenzie;
            $recenzie->utilizator_id = Auth::user()->id;
            $recenzie->produs_id = $id;
            $recenzie->titlu = $data['titlu'];
            $recenzie->nota = $data['nota'];
            $recenzie->comentariu = $data['comentariu'];
            $recenzie->save();
            return redirect()->back();
        }

    }

    public function recenzii($id = null)
    {
        $profilUtilizator = Auth::user();
        $utilizator = DB::table('utilizatori')->where('id', $id)->first();

        if (!empty($profilUtilizator->recenzii)) {
            $recenzii = $profilUtilizator->recenzii;
        }

        return view('layouts.profilLayout.recenzii')->with(compact('profilUtilizator', 'recenzii', 'date'));
    }

    public function solicitari($id = null)
    {
        $profilUtilizator = Auth::user();
        $utilizator = DB::table('utilizatori')->where('id', $id)->first();

        if (!empty($profilUtilizator->produseinchiriate)) {
            $produse_inchiriate = $profilUtilizator->produseinchiriate;
        }

        return view('layouts.profilLayout.solicitari_inchiriere')->with(compact('profilUtilizator', 'produse_inchiriate'));
    }

    public function adrese()
    {
        $profilUtilizator = Auth::user();
        $adrese = $profilUtilizator->adrese;
        return view('layouts.profilLayout.adresele-mele')->with(compact('profilUtilizator', 'adrese'));
    }

    public function modifica(Request $request)
    {
        if ($request->isMethod('post')) {
            $id = $request['id'];
            $adresa = Adresa::where('id', $request['id'])->first();
            $adresa->update(['adresa' => $request['value']]);
        }
    }

    public function sterge(Request $request)
    {
        if ($request->isMethod('post')) {
            $adresa = Adresa::where('id', $request['id'])->first();
            $adresa->delete();
        }
    }

    public function getAdresa(Request $request)
    {
        if ($request->isMethod('get')) {
            $adresa = Adresa::where('id', $request['id'])->first();
            return $adresa;
        }
    }

    public function getRegiuni(Request $request)
    {
        if ($request->isMethod('get')) {
            $oras = Oras::where('denumire', $request['denumire'])->first();
            $regiuni = Regiune::where('oras_id', $oras->id)->get();
            return $regiuni;
        }
    }

    public function comenzi($id = null)
    {
        $profilUtilizator = Auth::user();
        $adrese = $profilUtilizator->adrese;
        $comenzi = Comanda::where('utilizator_id', $id)->orderBy('created_at', 'DESC')->get();
        return view('layouts.profilLayout.comenzile-mele')->with(compact('comenzi', 'profilUtilizator'));
    }

    public function descarcaFactura($id = null)
    {
        $infoContact = InformatieContact::first();
        $comanda = Comanda::where('id', $id)->first();
        $utilizator = DB::table('utilizatori')->where('id', $comanda->utilizator_id)->first();
        $adresa = Adresa::withTrashed('id', $comanda->adresa_id)->first();
        $detalii = DetaliiCosCumparaturi::where('comanda_id', $id)->get();

        $inchiriate = null;
        if($comanda->produseinchiriate){
            $inchiriate = $comanda->produseinchiriate;
        }

        $pdf = PDF::loadView('layouts.profilLayout.factura',['infoContact'=>$infoContact,'utilizator'=>$utilizator,'adresa'=>$adresa,
            'comanda'=>$comanda,'detalii'=>$detalii,'inchiriate'=>$inchiriate])->setPaper('a4', 'landscape');;
        return $pdf->download('factura.pdf');
    }

    public function cupoane($id = null){
        $profilUtilizator = Auth::user();
        $cupoane = Cupon::where('utilizator_id',$id)
            ->where('aplicat',0)
            ->where('expira_la','>',Carbon::now())
            ->get();

        $puncte = PuncteLoialitate::where('utilizator_id',$id)->first();

        return view('layouts.profilLayout.cupoanele-mele')->with(compact('profilUtilizator','cupoane','puncte'));
    }
}

