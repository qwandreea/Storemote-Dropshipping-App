<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Furnizor;
use App\Produs;


class FurnizoriController extends Controller
{
    public function adaugaFurnizor(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            $furnizor=new Furnizor;
            $furnizor->denumire_furnizor=$data['denumire'];
            $furnizor->persoana_contact=$data['contact'];
            $furnizor->email=$data['email'];
            $furnizor->telefon=$data['telefon'];
            $furnizor->adresa=$data['adresa'];
            $furnizor->oras=$data['oras'];
            $furnizor->save();
            return redirect('/admin/vizualizeaza-furnizori')->with('modificare_cu_succes','Furnizorul a fost adaugat');
        }
        return view('admin.furnizori.adauga_furnizor');
    }

    public function vizualizeazaFurnizori(){
        $furnizori=Furnizor::get();
        return view('admin.furnizori.vizualizeaza_furnizori')->with(compact('furnizori'));
    }

    public function editeazaFurnizor($id=null,Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            $denumire=$data['denumire'];
            $persoana=$data['contact'];
            $email=$data['email'];
            $telefon=$data['telefon'];
            $adresa=$data['adresa'];
            $oras=$data['oras'];
            Furnizor::where(['id'=>$id])->update(['denumire_furnizor'=>$denumire ,'persoana_contact'=>$persoana , 'email'=>$email , 'telefon' =>$telefon ,
                'adresa'=>$adresa , 'oras'=>$oras]);
            return redirect('/admin/vizualizeaza-furnizori')->with('modificare_cu_succes','Modificarea a fost salvata cu succes');
        }
       $furnizorSelectat=Furnizor::where(['id'=>$id])->first();
        return view('admin.furnizori.editeaza_furnizor')->with(compact('furnizorSelectat'));
    }

    public function stergeFurnizor($id=null){
      if(!empty($id)){
            $furnizor=Furnizor::find($id);
            $furnizor->produse()->delete(); //stergerea produselor asociate cu furnizorul
            $furnizor->delete(); //stergerea furnizorului

          return redirect()->back()->with('modificare_cu_succes','Stergerea s-a realizat cu succes');
      }
    }

    public function vizualizeazaProduseFurnizor($id=null){
        $nrFurn = Furnizor::where(['id'=>$id])->count();
        if($nrFurn == 0 ) return view('layouts.storeLayout.404');

        $furnizor = Furnizor::find($id);
        $produseFurnizori = $furnizor->produse;
        return view('layouts.storeLayout.pagina-produse.filtrare_furnizori')->with(compact('produseFurnizori','furnizor'));
    }
}
