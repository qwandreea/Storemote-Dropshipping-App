<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Session;
use App\User;
use App\Promotie;
use App\Produs;
use Image;
use App\ProdusInchiriat;
use App\InformatieContact;
use App\Oras;
use App\Taxa;
use App\IntrebareForum;
use App\Comanda;
use App\CosCumparaturi;
use Excel;
use App\SpecificatieTehnica;
use App\DetaliiCosCumparaturi;
use App\PuncteLoialitate;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $credentials = $request->input();
            if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'admin' => 1])) {
                return redirect('/admin/tablou');
            }
            if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'admin' => 0])) {
                return redirect('/');
            } else {
                return redirect('/admin')->with('admin_error_login', 'Email sau parola invalide.');
            }
        }
        return view('admin.admin_login');
    }

    public function tablou()
    {
        $statusComanda = ['In procesare', 'Livrata', 'Platita', 'In depozit'];
        $nrUtilizatori = DB::table('utilizatori')->where('admin', 0)->count();
        $nrSolicitari = ProdusInchiriat::where('status', 'In asteptare')->count();
        $nrComenzi = Comanda::whereIn('status', $statusComanda)->count();
        $nrCosuri = CosCumparaturi::all()->count();
        $nrComenziOnline = Comanda::where('modalitate_plata', 'online')->count();
        $nrComenziAzi = Comanda::where('created_at', Carbon::now())->count();


        $c = Comanda::select([
            DB::raw('count(id) as `count`'),
            DB::raw('sum(total) as `sum`'),
            // This throws away the timestamp portion of the date
            DB::raw('DATE(created_at) as day')
            // Group these records according to that day
        ])->groupBy('day')
            // And restrict these results to only those created in the last week
            ->whereDate('created_at', '=', Carbon::today())
            ->first();

        $bestThreeSeller = DetaliiCosCumparaturi::whereNotNull('comanda_id')
            ->join('produse','detalii_cos_cumparaturi.produs_id','=','produse.id')
            ->select('produs_id','produse.denumire', DB::raw('COUNT(produs_id) as count'))
            ->groupBy('produs_id','produse.denumire')
            ->orderBy('count', 'desc')
            ->take(3)
            ->get();

        $totalProductsSell = DetaliiCosCumparaturi::whereNotNull('comanda_id')
            ->select(DB::raw('COUNT(produs_id) as cnt'))
            ->first();

        return view('admin.admin_tablou_bord', ['nrUsers' => $nrUtilizatori, 'nrSolicitari' => $nrSolicitari, 'nrComenzi' => $nrComenzi,
            'nrCosuri' => $nrCosuri, 'nrComenziOnline' => $nrComenziOnline, 'nrComenziAzi' => $nrComenziAzi,'bestThreeSeller'=>$bestThreeSeller
        ,'total'=>$totalProductsSell]);
    }

    public function setari()
    {
        return view('admin.admin_setari');
    }

    public function verificareParola(Request $request)
    {

        $data = $request->all();
        $parola = $data['parola'];
        $parola_check = User::where(['admin' => 1])->first();
        if (Hash::check($parola, $parola_check->password)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function schimbaParola(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $parola_check = User::where(['email' => Auth::user()->email])->first();
            $parola = $data['parola'];
            if (Hash::check($parola, $parola_check->password)) {
                $parola_noua = bcrypt($data['parola_noua']);
                User::where('admin', '1')->update(['password' => $parola_noua]);
                return redirect('/admin/setari')->with('admin_success_change', 'Parola a fost modificata cu succes.');
            } else {
                return redirect('/admin/setari')->with('admin_error_change', 'Parola este incorecta.');
            }
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/admin');
    }

    public function modificaInfoContact(Request $request)
    {
        $informatii = InformatieContact::first();
        $data = $request->all();

        if ($request->isMethod('post')) {
            $informatie = InformatieContact::find($data['id']);
            $informatie->update(['adresa' => $data['adresa'], 'email' => $data['email'], 'telefon' => $data['telefon'], 'skype' => $data['skype']]);
            return redirect()->back()->with('succes', 'Modificarea a fost salvata');
        }
        return view('admin.CMS.adauga-informatii-contact')->with(compact('informatii'));
    }

    public function vizualizarePromotii()
    {
        $promotii = Promotie::all();;
        return view('admin.CMS.lista_promotii')->with(compact('promotii'));
    }

    public function adaugaPromotie(Request $request)
    {
        $data = $request->all();
        if ($request->isMethod('post')) {
            $promotie = new Promotie;
            $promotie->titlu = $data['titlu'];
            $promotie->mesaj_promotie = $data['mesaj'];

            if ($request->hasFile('imagine')) {
                $imagine = Input::file('imagine');
                if ($imagine->isValid()) {
                    $numefisier = time() . '.' . $imagine->getClientOriginalExtension();
                    Image::make($imagine)->save(public_path('uploads/admin/' . $numefisier));
                    $promotie->banner = $numefisier;
                }
            }

            $promotie->save();
            return redirect()->back()->with('modificare_cu_succes', 'Promotia a fost adaugata');
        }
    }

    public function editeazaPromotie(Request $request, $id = null)
    {
        $data = $request->all();
        $promotie = Promotie::where('id', $id)->first();
        if ($request->isMethod('post')) {
            $promotie->update(['titlu' => $data['titlu'], 'mesaj_promotie' => $data['mesaj']]);

            if ($request->hasFile('banner')) {
                $imagine = Input::file('banner');
                if ($imagine->isValid()) {
                    $numefisier = time() . '.' . $imagine->getClientOriginalExtension();
                    Image::make($imagine)->save(public_path('uploads/admin/' . $numefisier));
                    $promotie->update(['banner' => $numefisier]);
                }
            }
            return redirect()->back()->with('modificare_cu_succes', 'Promotia a fost modicata');
        }
    }

    public function stergePromotie($id = null)
    {
        if (!empty($id)) {
            $promotie = Promotie::find($id);
            $promotie->delete(); //stergere categorie
            return redirect()->back()->with('modificare_cu_succes', 'Stergerea s-a realizat cu succes');
        }
    }

    public function vizualizareSolicitari()
    {
        $solicitari = ProdusInchiriat::all();
        return view('admin.comenzi.administrare_inchiriere')->with(compact('solicitari'));
    }

    public function schimbaStatusSolicitare(Request $request)
    {
        $produs = ProdusInchiriat::where('id', $request['id'])->first();
        $produs->update(['status' => $request['sts']]);
    }

    public function vizualizareTaxe()
    {
        $rezultate = Oras::select(DB::Raw('taxa_orase.id,orase.cod,orase.denumire,taxa_orase.taxa'))
            ->join('taxa_orase', 'orase.id', '=', 'taxa_orase.oras_id')
            ->get();

        return view('admin.comenzi.taxa-regiuni')->with(compact('rezultate'));
    }

    public function modificaTaxa(Request $request)
    {
        if ($request->isMethod('post')) {
            $taxa = Taxa::find($request['id']);
            $taxa->update(['taxa' => $request['taxa']]);
            echo 'updated';
        }
    }

    public function intrebariForum()
    {
        return view('admin.forum.view-forum');
    }

    public function raspunsForum($id = null, Request $request)
    {
        $intrebare = IntrebareForum::where('id', $id)->first();
        $admin = DB::table('utilizatori')->where('id', auth()->user()->id)->orWhere('admin', 0)->first();
        if ($request->isMethod('post')) {
            $raspuns = new IntrebareForum;
            $raspuns->id_parinte = $id;
            $raspuns->id_user = $admin->id;
            $raspuns->titlu = $request['titlu'];
            $raspuns->continut = $request['raspuns'];
            $raspuns->save();
            return redirect('/admin/forum-clienti')->with('modificare_cu_succes', 'Raspunsul a fost trimis');
        }

        return view('admin.forum.raspunde-intrebare-forum')->with(compact('intrebare'));
    }

    public function listaComenzi(Request $request)
    {
        if ($request->ajax()) {
            if ($request['filtru'] === 'modalitate_plata') {
                $comenzi = Comanda::where(['modalitate_plata' => $request['by']])->get();
            } else if ($request['filtru'] === 'status') {
                $comenzi = Comanda::where(['status' => $request['by']])->get();
            } else {
                $comenzi = Comanda::orderBy('created_at', 'DESC')->get();
            }
            return $comenzi;
        }
        $comenzi = Comanda::orderBy('created_at', 'DESC')->get();
        return view('admin.comenzi.lista-comenzi', ['comenzi' => $comenzi]);
    }

    public function detaliiComanda($id = null)
    {
        $comanda = Comanda::findOrFail($id);
        return view('admin.comenzi.detalii-comanda', ['comanda' => $comanda]);
    }

    public function schimbaStatus(Request $request, $id = null)
    {
        if ($request->ajax()) {
            $comanda = Comanda::where('id', $id)->first();
            $comanda->update(['status' => $request['stare']]);

            if($request->stare === 'Livrata'){
                PuncteLoialitate::storePointsToDatabase($comanda->subtotal,$comanda->utilizator_id);
            }
            return 'updated';
        }
    }

    public function importProduse(Request $request)
    {
        if ($request->hasFile('file-produse')) {
            $path = $request->file('file-produse')->getRealPath();
            $data = Excel::load($path)->get();
            foreach ($data as $inregistrare) {
                $produs = new Produs;
                $produs->furnizor_id = $inregistrare->furnizor_id;
                $produs->id_categorie = $inregistrare->id_categorie;
                $produs->cod_produs = $inregistrare->cod_produs;
                $produs->denumire = $inregistrare->denumire;
                $produs->descriere = $inregistrare->descriere;
                $produs->pret_unitar = $inregistrare->pret_unitar;
                $produs->imagine = $inregistrare->imagine;
                $produs->pret_inchiriere_ora = $inregistrare->pret_inchiriere_ora;
                $produs->pret_inchiriere_zi = $inregistrare->pret_inchiriere_zi;
                $produs->de_inchiriat = $inregistrare->de_inchiriat;
                $produs->save();

                $specificatie = new SpecificatieTehnica;
                $specificatie->produs_id = $produs->id;
                $specificatie->culoare = $inregistrare->culoare;
                $specificatie->material = $inregistrare->material;
                $specificatie->stoc = $inregistrare->stoc;
                $specificatie->greutate = $inregistrare->greutate;
                $specificatie->unitate_masura_greutate = $inregistrare->unitate_masura_greutate;
                $specificatie->lungime = $inregistrare->lungime;
                $specificatie->latime = $inregistrare->latime;
                $specificatie->inaltime = $inregistrare->inaltime;
                $specificatie->unitate_masura = $inregistrare->unitate_masura;
                $specificatie->save();
            }
        }

        return redirect()->back()->with('modificare_cu_succes', 'Datele au fost stocate');
    }
}
