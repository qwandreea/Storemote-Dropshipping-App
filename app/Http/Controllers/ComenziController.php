<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CosCumparaturi;
use App\Oras;
use App\Taxa;
use App\Adresa;
use App\Comanda;
use App\Cupon;
use Illuminate\Support\Facades\Session;


class ComenziController extends Controller
{
    public function checkout($id = null)
    {
        $cosCumparaturi = CosCumparaturi::where('id', $id)->first();
        return view('layouts.storeLayout.cos-cumparaturi.checkout')->with(compact('cosCumparaturi'));
    }

    public function getTaxaByAdresa(Request $request)
    {
        if ($request->isMethod('get')) {
            $oras = Oras::where('denumire', $request['numeOras'])->first();
            $taxa = $oras->taxa->taxa;
            $valoareCos = 0;
            $totalCos = 0;

            $cos = CosCumparaturi::where('id', $request['idCos'])->first();
            if (!$cos->detaliicos->isEmpty()) {
                foreach ($cos->detaliicos as $detalii) {
                    $valoareCos += $detalii->pret * $detalii->cantitate;
                }
            }

            if (!$cos->produseInchiriate->isEmpty()) {
                foreach ($cos->produseInchiriate as $inchiriate) {
                    $valoareCos += $inchiriate->subtotal;
                }
            }

            $totalCos = $taxa + $valoareCos;

            return response()->json(['taxa' => $taxa, 'valoareCos' => $valoareCos, 'totalCos' => $totalCos]);
        }

    }

    public function paypal()
    {
        return view('layouts.storeLayout.cos-cumparaturi.paypal');
    }

    public function inregistrareComanda($idCos = null, Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'adresa' => 'required|string',
                'codpostal' => 'required|numeric|digits:6'
            ], [
                'required' => 'Campul :attribute trebuie completat',
                'codpostal.max' => 'Campul trebuie sa contina 6 caractere de tip numeric',
                'codpostal.numeric' => 'Codul postal trebuie sa contina caractere de tip numeric',
                'codpostal.digits' => 'Codul postal trebuie sa aiba exact 6 caractere numerice'
            ]);


            if (Comanda::orderBy('created_at', 'DESC')->first() === null) {
                $latestOrder = 0;
            } else {
                $ultimaComanda = Comanda::orderBy('created_at', 'DESC')->first();
                $latestOrder = $ultimaComanda->id;
            }

            $adresaId = null;
            if (!$request->exists('adresa-existenta')) {
                $adresa = new Adresa;
                $adresa->utilizator_id = auth()->user()->id;
                $adresa->adresa = $request['adresa'];
                $adresa->cod_postal = $request['codpostal'];
                $adresa->oras = $request['oras'];
                $adresa->regiune = $request['regiune'];
                $adresa->save();
                $adresaId = $adresa->id;
            } else {
                $adresaId = $request['adresa-existenta'];
            }

            $comanda = new Comanda;
            $comanda->nr_comanda = '#' . str_pad($latestOrder + 1, 5, "0", STR_PAD_LEFT);
            $comanda->utilizator_id = auth()->user()->id;
            $comanda->adresa_id = $adresaId;
            $comanda->modalitate_plata = $request['plata'];
            $comanda->subtotal = $request['subtotal'];
            $comanda->taxa = $request['taxa'];
            $comanda->total = $request['total'];
            $comanda->save();

            $cosCumparaturiCurent = CosCumparaturi::find($idCos);
            if ($cosCumparaturiCurent->detaliicos) {
                foreach ($cosCumparaturiCurent->detaliiCos as $produs_comandat) {
                    $produs_comandat->comanda_id = $comanda->id;
                    $produs_comandat->produs->specificatie->update(['stoc' => $produs_comandat->produs->specificatie->stoc - $produs_comandat->cantitate]);
                    $produs_comandat->save();
                }
            }
            if ($cosCumparaturiCurent->produseInchiriate) {
                foreach ($cosCumparaturiCurent->produseInchiriate as $produs_comandat) {
                    $produs_comandat->comanda_id = $comanda->id;
                    $produs_comandat->produs->specificatie->stoc;
                    $produs_comandat->produs->specificatie->update(['stoc' => $produs_comandat->produs->specificatie->stoc - $produs_comandat->cantitate]);
                    $produs_comandat->status = 'Comandat';
                    $produs_comandat->save();
                }
            }

            if($request['cod-cupon']!==null){
                $cupon = Cupon::where(['cod_cupon'=>$request['cod-cupon']])->first();
                $cupon->aplicat=true;
                $cupon->save();
            }

            if ($request['plata'] === 'cash') {
                session()->forget('id_sesiune');
                return redirect()->back()->with('succes', 'Comanda dumneavoastra a fost inregistrat');
            } else {
                return redirect('/paypal')
                    ->with(['total' => $comanda->total, 'taxa' => $comanda->taxa, 'nrcomanda' => $comanda->nr_comanda, 'idcos' => $idCos, 'idadresa' => $adresaId, 'iduser' => $comanda->utilizator->id
                    ,'cupon'=>$request['cod-cupon']]);
            }
        }
    }

    public function aplicaCupon(Request $request)
    {
        if ($request->ajax()) {
            $cod = $request['cod-cupon'];
            $valoare = $request['valoareCos'];
            $cautaCupon = Cupon::where('cod_cupon', $cod)->first();
            if ($cautaCupon && $cautaCupon->aplicat===0) {
                if ($cautaCupon->tip_cupon === 'procent') {
                    $valoareCupon = ($cautaCupon->valoare);
                    $sumaScazuta = $valoare * $valoareCupon / 100;
                    $valoare = $valoare - $sumaScazuta;
                    return response()->json(['valoare' => $valoare, 'sumaScazuta' => $sumaScazuta,'cupon'=>$cod]);
                }
            } else {
                return 'neidentificat';
            }
        }
    }
}
