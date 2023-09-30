<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorie;
use App\Produs;
use App\Furnizor;
use App\SpecificatieTehnica;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Input;
use Image;
use App\ProdusInchiriat;
use App\CosCumparaturi;
use Illuminate\Support\Facades\Session;


class ProduseController extends Controller
{

    public function getDaysBetweenTwoDates($start,$end)
    {

        $interval = round((strtotime($end) - strtotime($start))/86400, 1);
        return $interval;
    }

    function getHoursBetweenTwoDatetimes($start,$end){
        $interval = round((strtotime($end) - strtotime($start))/3600, 1);
        return $interval;
    }

    public function pretProdusInchiriere(Request $request)
    {
        if ($request->ajax()) {
            $prodId = $request['idProd'];
            $tip = $request['tip'];
            $cantitate = $request['cantitate'];
            $dataInceput = $request['dataInceput'];
            $dataSfarsit = $request['dataSfarsit'];

            $produs = Produs::find($prodId);
            switch ($tip) {
                case('zi'):
                    $pret = $produs->pret_inchiriere_zi;
                    $nrZile = floor($this->getDaysBetweenTwoDates($dataInceput,$dataSfarsit));
                    if($nrZile == 0){
                        $nrZile = 1;
                    }
                    $subtotal = $pret*$nrZile*$cantitate;
                    break;
                case('ora'):
                    $pret = $produs->pret_inchiriere_ora;
                    $nrOre = $this->getHoursBetweenTwoDatetimes($dataInceput,$dataSfarsit);
                    if($nrOre == 0) {
                        $nrOre = 1;
                    }
                    $subtotal =$pret*$nrOre*$cantitate;
                    break;
            }
            if($subtotal > 0)
                echo $subtotal;
        }
    }

    protected $categoriiInchiriere = array();

    public function categorieDeInchiriere($array)
    {
        $categorii = Categorie::whereIn('denumire', $array)->select('denumire', 'id')->get();
        foreach ($categorii as $categorie) {
            $this->categoriiInchiriere[] = $categorie->denumire;
            $subcategorii = Categorie::where('id_parinte', $categorie->id)->get();
            foreach ($subcategorii as $subcategorie) {
                $this->categoriiInchiriere[] = $subcategorie->denumire;
            }
        }
        return $this->categoriiInchiriere;
    }

    public function initArrayCategoriiInchiriat($array)
    {
        $return_array = array();
        foreach ($array as $arr) {
            $return_array[] = $arr;
        }
        return $return_array;
    }

    public function adaugaProdus(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $validatedData = $request->validate([
                'cod_produs' => 'unique:produse'
            ], [
                'unique' => 'Codul de produs trebuie sa fie unic'
            ]);

            $produs = new Produs;
            $produs->furnizor_id = $data['furnizor_produs'];
            $produs->id_categorie = $data['categorie_produs'];
            $produs->cod_produs = $data['cod_produs'];
            $produs->denumire = $data['denumire_produs'];
            $produs->descriere = $data['descriere_produs'];
            $produs->pret_unitar = $data['pret_produs'];
            $produs->pret_inchiriere_ora = $data['pret_ora_produs'];
            $produs->pret_inchiriere_zi = $data['pret_zi_produs'];

            if ($request->hasFile('imagine_produs')) {
                $imagine = Input::file('imagine_produs');
                if ($imagine->isValid()) {
                    $numefisier = time() . '.' . $imagine->getClientOriginalExtension();
                    Image::make($imagine)->resize(300, 500)->save(public_path('uploads/produse/' . $numefisier));
                    $produs->imagine = $numefisier;
                }
            }

            $init = $this->initArrayCategoriiInchiriat(array('Utilaje constructii'));
            if (in_array($produs->categorie->denumire, $this->categorieDeInchiriere($init))) {
                $produs->de_inchiriat = 1;
            }

            $produs->save();
            return redirect()->back()->with('modificare_cu_succes', 'Produsul a fost adaugat cu succes');
        }
        $categorii_principale = Categorie::where(['id_parinte' => 0])->get();
        $select = "";
        foreach ($categorii_principale as $categorie) {
            $select .= "<option style='font-weight:bold;' value = '" . $categorie->id . "'>" . $categorie->denumire . "</option>";
            $subcategorii = Categorie::where(['id_parinte' => $categorie->id])->get();
            foreach ($subcategorii as $subcategorie) {
                $select .= "<option value = '" . $subcategorie->id . "'>&bull; &nbsp;" . $subcategorie->denumire . "</option>";
            }
        }

        $furnizori = Furnizor::get();
        $selectFurnizor = "";
        foreach ($furnizori as $furnizor) {
            $selectFurnizor .= "<option style='font-weight:bold;' value = '" . $furnizor->id . "'>" . $furnizor->denumire_furnizor . "</option>";
        }
        return view('admin.produse.adauga_produs')->with(compact('select', 'selectFurnizor'));
    }

    public function vizualizeazaProduse()
    {
        $produse = Produs::get();
        return view('admin.produse.vizualizeaza_produse')->with(compact('produse'));
    }

    public function editeazaProdus($id = null, Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            $produsModificat = Produs::where(['id' => $id]);

            if ($request->hasFile('imagine_produs')) {
                $imagine = Input::file('imagine_produs');
                if ($imagine->isValid()) {
                    $numefisier = time() . '.' . $imagine->getClientOriginalExtension();
                    Image::make($imagine)->resize(300, 500)->save(public_path('uploads/produse/' . $numefisier));
                    $produsModificat->imagine = $numefisier;
                }
            } else {
                $numefisier = $data['imagine_produs'];
                $produsModificat->imagine = $numefisier;
            }

            $produsModificat->update(['furnizor_id' => $data['furnizor_produs'], 'id_categorie' => $data['categorie_produs'], 'cod_produs' => $data['cod_produs'],
                'denumire' => $data['denumire_produs'], 'descriere' => $data['descriere_produs'], 'pret_unitar' => $data['pret_produs'], 'imagine' => $numefisier,
                'pret_inchiriere_ora' => $data['pret_ora_produs'], 'pret_inchiriere_zi' => $data['pret_zi_produs']]);
            return redirect('/admin/vizualizeaza-produse')->with('modificare_cu_succes', 'Modificarea a fost salvata cu succes');
        }

        $produs = Produs::where(['id' => $id])->first();
        $select = "";
        $categorii_principale = Categorie::where(['id_parinte' => 0])->get();
        foreach ($categorii_principale as $categorie) {
            if ($categorie->id == $produs->id_categorie) {
                $categorieSelectata = "selected";
            } else {
                $categorieSelectata = "";
            }
            $select .= "<option style='font-weight:bold;' value = '" . $categorie->id . "'" . $categorieSelectata . ">" . $categorie->denumire . "</option>";
            $subcategorii = Categorie::where(['id_parinte' => $categorie->id])->get();
            foreach ($subcategorii as $subcategorie) {
                if ($subcategorie->id == $produs->id_categorie) {
                    $categorieSelectata = "selected";
                } else {
                    $categorieSelectata = "";
                }
                $select .= "<option value = '" . $subcategorie->id . "'" . $categorieSelectata . ">&bull; &nbsp;" . $subcategorie->denumire . "</option>";
            }
        }

        $furnizori = Furnizor::get();
        $selectFurnizor = "";
        foreach ($furnizori as $furnizor) {
            if ($furnizor->id == $produs->furnizor_id) {
                $furnizorSelectat = "selected";
            } else {
                $furnizorSelectat = "";
            }
            $selectFurnizor .= "<option style='font-weight:bold;' value = '" . $furnizor->id . "'.$furnizorSelectat.>" . $furnizor->denumire_furnizor . "</option>";
        }

        return view('admin.produse.editeaza_produs')->with(compact('produs', 'select', 'selectFurnizor'));
    }

    public function stergeProdus($id = null)
    {
        $produs = Produs::find($id);
        if ($produs->specificatii) {
            $produs->specificatii()->delete();
        }
        $produs->delete();
        return redirect()->back()->with('modificare_cu_succes', 'Produsul a fost sters cu succes');
    }

    public function adaugaSpecificatii($id = null, Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            foreach ($data['culoare'] as $cheie => $valoare) {
                if (!empty($valoare)) {
                    $specificatii = new SpecificatieTehnica;
                    $specificatii->produs_id = $id;
                    $specificatii->culoare = $valoare;
                    $specificatii->material = $data['material'][$cheie];
                    $specificatii->stoc = $data['stoc'][$cheie];
                    $specificatii->greutate = $data['greutate'][$cheie];
                    $specificatii->unitate_masura_greutate = $data['masura'][$cheie];
                    $specificatii->lungime = $data['lungime'][$cheie];
                    $specificatii->latime = $data['latime'][$cheie];
                    $specificatii->inaltime = $data['inaltime'][$cheie];
                    $specificatii->unitate_masura = $data['unitate'][$cheie];
                    $specificatii->save();
                }
            }
            return redirect('admin/produs/adauga-specificatii/' . $id)->with('modificare_cu_succes', 'Specificatiile au fost adaugate.');
        }
        $produs = Produs::find($id);
        $specificatii = $produs->specificatie;
        return view('admin.produse.specificatii_produse.adauga_specificatii')->with(compact('produs', 'specificatii'));
    }

    public function stergeSpecificatii($id = null)
    {
        SpecificatieTehnica::where(['id' => $id])->delete();
        return redirect()->back()->with('modificare_cu_succes', 'Stergerea a fost realizata cu succes');
    }

    public function editeazaSpecificatii($id = null, Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $specificatie = Produs::find($id)->specificatie;
            $specificatie->update(['culoare' => $data['culoare'], 'material' => $data['material'], 'stoc' => $data['stoc']]);
            return redirect('/admin/produs/adauga-specificatii/' . $id)->with('modificare_cu_succes', 'Modificarea a fost salvata cu succes');
        }
    }

    public function detaliiProdus($id = null)
    {

        $nrProd = Produs::where(['id' => $id])->count();
        if ($nrProd == 0) return view('layouts.storeLayout.404');

        $detaliiProdus = Produs::where(['id' => $id])->first();
        $produseAsociate = Produs:: where('id', '!=', $id)->where(['id_categorie' => $detaliiProdus->id_categorie])->get();
        $numarAsociate = $produseAsociate->count();
        if (!empty($detaliiProdus->recenzii)) {
            $recenzii = $detaliiProdus->recenzii;
        }

        if (empty($detaliiProdus->id)) {
            return view('layouts.storeLayout.404');
        }
        return view('layouts.storeLayout.pagina-produse.detalii_produs')->with(compact('detaliiProdus', 'produseAsociate', 'numarAsociate', 'recenzii'));
    }

    public function setDeInchiriat(Request $request)
    {
        $input = $request->all();
        $prod_id = explode("-", $input['prod_id']);
        $produs = Produs::findOrFail($prod_id[0]);
        if ($produs->de_inchiriat === 1) {
            $produs->update(['de_inchiriat' => 0]);
        } else {
            $produs->update(['de_inchiriat' => 1]);
        }
    }

}
