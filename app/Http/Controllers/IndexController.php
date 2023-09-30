<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Categorie;
use App\Produs;
use App\Furnizor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\IntrebareForum;
use App\Comanda;
use App\DetaliiCosCumparaturi;


class IndexController extends Controller
{
    public function index()
    {
//        $furnizor = Furnizor::first();
//        $comenzi = Comanda::whereDate('created_at',Carbon::today())->get();
//        return view('comenzi_mail',["comenzi"=>$comenzi,"furnizor"=>$furnizor,"data"=>Carbon::today()]);
        return view('index');
    }

    public function paginaProduse()
    {
        return view('layouts.storeLayout.pagina-produse.pagina_produse');
    }

    public function paginaProduseInchiriere()
    {
        return view('layouts.storeLayout.pagina-produse.pagina_produse_inchiriere');
    }

    public function categoriiFilter($catUrl = null)
    {
        $notFountParameter = Categorie::where(['adr_url'=>$catUrl])->count();
        if($notFountParameter==0){
            return view('layouts.storeLayout.404');
        }
        $categorieSelectata = Categorie::where(['adr_url' => $catUrl])->first();
        $idCategorie = $categorieSelectata->id;
        $producteCategorieSelectata = Produs::whereHas('categorie', function ($query) use ($idCategorie) {
            $query->where('id_parinte', $idCategorie);
        })->get();


        return view('layouts.storeLayout.pagina-produse.filtrare_categorii')->with(compact( 'categorieSelectata', 'producteCategorieSelectata'));

    }

    public function subcategoriiFilter($subcatUrl = null)
    {
        $notFoundParameter=Categorie::where(['adr_url'=>$subcatUrl])->count();
        if($notFoundParameter==0){
            return view('layouts.storeLayout.404');
        }
        $subcategorieSelectata = Categorie::where(['adr_url' => $subcatUrl])->first();
        $produseSubcategorie = $subcategorieSelectata->produse;
        return view('layouts.storeLayout.pagina-produse.filtrare_subcategorii')->with(compact('subcategorieSelectata', 'produseSubcategorie'));
    }

    public function search(){
       $query= Input::get('search');

        $rezultat = Produs::select(DB::Raw('produse.*'))
            ->join('specificatii_tehnice', 'produse.id', '=', 'specificatii_tehnice.produs_id')
            ->where('produse.denumire','LIKE','%'.$query.'%')
            ->orWhere('cod_produs','LIKE','%'.$query.'%')
            ->orWhere('specificatii_tehnice.material','LIKE','%'.$query.'%')
            ->get();

        $count = $rezultat->count();

        if(count($rezultat) >= 0){
            return view('layouts.storeLayout.pagina-produse.search_results')->with(compact('rezultat','query','count'));
        }
    }

    public function intrebareForum(Request $request){
        $data = $request->all();

           $intrebare = new IntrebareForum;
           $intrebare->id_parinte = 0;
           $intrebare->titlu = $data['titlu'];
           $intrebare->continut = $data['mesaj'];
           if(Auth::user()){
               $intrebare->id_user = Auth::user()->id;
           }
           $intrebare->save();
           return redirect()->back();
    }

    public function viewForum(){
        return view('layouts.storeLayout.forum.forum');
    }

    public function raspunsuriForum($id = null){
        $notFoundParameter = IntrebareForum::where(['id'=>$id])->count();
        if($notFoundParameter==0){
            return view('layouts.storeLayout.404');
        }
        $intrebareForum = IntrebareForum::where(['id'=>$id])->first();

        return view('layouts.storeLayout.forum.chat-forum')->with(compact('intrebareForum'));
    }

    public function adaugaRaspuns(Request $request){
        $idParinte = $request['idParinte'];
        $idUser = $request['userId'];
        $continut = $request['continut'];

        $raspuns = new IntrebareForum;
        $raspuns->id_parinte = $idParinte;
        $raspuns->id_user = $idUser;
        $raspuns->titlu = null;
        $raspuns->continut = $continut;
        $raspuns->save();
        return $raspuns;
    }

}
