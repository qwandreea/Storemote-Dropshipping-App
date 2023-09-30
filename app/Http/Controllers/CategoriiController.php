<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorie;

class CategoriiController extends Controller
{
    public function adaugaCategorie(Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            $categorie=new Categorie;
            $categorie->id_parinte=$data['tip_categorie'];
            $categorie->denumire=$data['denumire'];
            $categorie->descriere=$data['descriere'];
            $categorie->adr_url=$data['adr_url'];
            $categorie->save();
            return redirect('/admin/vizualizeaza-categorii');
        }
        $parinte=Categorie::where(['id_parinte'=>0])->get();
        return view('admin.categorii.adauga_categorie')->with(compact('parinte'));
    }

    public function vizualizeazaCategorii(){
        $categorii=Categorie::get();
        return view('admin.categorii.vizualizeaza_categorii')->with(compact('categorii'));
    }

    public function editeazaCategorie($id, Request $request){
        if($request->isMethod('post')){
            $data=$request->all();
            $denumire=$data['denumire'];
            $descriere=$data['descriere'];
            $adr_url=$data['adr_url'];
            Categorie::where(['id'=>$id])->update(['denumire'=>$denumire,'descriere'=>$descriere,'adr_url'=>$adr_url]);
            return redirect('/admin/vizualizeaza-categorii')->with('modificare_cu_succes','Modificarea a fost salvata cu succes');
        }
        $categorieSelectata = Categorie::where(['id'=>$id])->first();
        $parinte=Categorie::where(['id_parinte'=>0])->get();

        return view('admin.categorii.editeaza_categorie')->with(compact('categorieSelectata','parinte'));
    }

    public function stergeCategorie($id=null){
        if(!empty($id)){
            $categorie=Categorie::find($id);
            $categorie->produse()->delete(); //stergere produse asociate categoriei
            $categorie->delete(); //stergere categorie
            return redirect()->back()->with('modificare_cu_succes','Stergerea s-a realizat cu succes');
        }
    }


}
