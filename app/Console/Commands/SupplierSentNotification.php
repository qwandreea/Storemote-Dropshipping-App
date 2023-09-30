<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Mail;
use App\Furnizor;
use App\Comanda;
use App\Http\Controllers\Controller as controller;
use Barryvdh\DomPDF\Facade as PDF;
use Sabberworm\CSS\Value\CalcRuleValueList;

class SupplierSentNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:supplier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notificari pe email cu comenzi de la fiecare furnizor';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $title = 'Comenzile de astazi de la ' . env('APP_NAME');
        $furnizori = Furnizor::all();
        $comenzi = Comanda::whereDate('created_at', Carbon::today())->get();
        if($comenzi->count() !== 0)
        foreach ($furnizori as $furnizor) {
            $pdf = PDF::loadView('comenzi_mail', ["comenzi" => $comenzi, "furnizor" => $furnizor, "data" => Carbon::today()])->setPaper('a4', 'landscape');
            Mail::raw($title, function ($message) use ($furnizor, $pdf) {
                $message->from('mogosandreea17@stud.ase.ro');
                $message->to($furnizor->email)->subject('Comenzile zilnice');
                $message->attachData($pdf->output(), "comenzi.pdf");
            });
        }
    }
}


