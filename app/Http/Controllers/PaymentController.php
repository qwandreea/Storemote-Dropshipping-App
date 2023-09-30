<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All Paypal Details class **/

use PayPal;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use App\Adresa;
use App\CosCumparaturi;
use App\DetaliiCosCumparaturi;
use App\Tranzactie;
use App\Comanda;
use App\PuncteLoialitate;
use App\Cupon;


class PaymentController extends Controller
{

    private $_api_context;
    private static $payment_method = 'paypal';
    private static $currency = 'EUR';
    private static $curs = 4.83;
    private $details;

    public function __construct()
    {
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }


    public function payWithpaypal(Request $request)
    {
        $taxa = $request['tax']/self::$curs;
        $nrcomanda = $request['nrcomanda'];
        $idcos = $request['idcos'];
        $cupon = $request['idcupon'];

        $cos = CosCumparaturi::where('id', $idcos)->first();
        $cupon_discount = Cupon::where('cod_cupon',$cupon)->first();
        if($cupon_discount === null){
            $discount = 0;
        }else{
            $discount = $cupon_discount->valoare/100;
        }

        $payer = new Payer();
        $payer->setPaymentMethod(self::$payment_method);
        $this->details = new Details();

        $item = array();
        $i = 1;
        $total = 0;

        if ($cos->detaliicos) {
            foreach ($cos->detaliicos as $produs) {
                    $item[$i] = new Item();
                    $item[$i]->setName($produs->produs->denumire)->setCurrency(self::$currency)->setQuantity($produs->cantitate)->setPrice(($produs->produs->pret_unitar-$produs->produs->pret_unitar*$discount)/self::$curs);
                    $this->details->setSubtotal($this->details->getSubtotal() +
                        $produs->cantitate * ($produs->produs->pret_unitar-$produs->produs->pret_unitar*$discount)/self::$curs);
                    $i++;
                    $total += ($produs->cantitate * ($produs->produs->pret_unitar-$produs->produs->pret_unitar*$discount))/self::$curs;
            }
        }



        if ($cos->produseInchiriate) {
            foreach ($cos->produseInchiriate as $produs) {
                $item[$i] = new Item();
                $item[$i]->setName($produs->produs->denumire)->setCurrency(self::$currency)->setQuantity($produs->cantitate)->setPrice(($produs->subtotal / $produs->cantitate)/self::$curs);
                $this->details->setSubtotal($this->details->getSubtotal() + $produs->subtotal/self::$curs);
                $i++;
                $total += $produs->subtotal/self::$curs;
            }
        }

        $item_list = new ItemList();
        $item_list->setItems($item);

        $this->details->setTax($taxa);

        $total+=number_format((float)$taxa,2);



        $amount = new Amount();
        $amount->setCurrency(self::$currency)
            ->setDetails($this->details)
            ->setTotal($total);


        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setNoteToPayee('Tranzactia pentru comanda nr ' . $nrcomanda)
            ->setDescription('Tranzactia pentru comanda nr ' . $nrcomanda);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('status'))
        ->setCancelUrl(URL::route('status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return Redirect::to('/');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('/');
            }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        Session::put('idcos', $request['idcos']);
        Session::put('nrcomanda', $nrcomanda);
        Session::forget('id_sesiune');
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
        return Redirect::to('/');
    }

    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        $comanda = Comanda::where('nr_comanda',Session::get('nrcomanda'))->first();

        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {

            \Session::put('error', 'Payment failed');
            return Redirect::to('/');

        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            $comanda->update(['status'=>'Platita']);

            $uniqueTransactionId = $payment->transactions[0]->related_resources[0]->sale->id;

            $tranzactie = new Tranzactie;
            $tranzactie->payid = $payment_id;
            $tranzactie->tranzactie_id = $uniqueTransactionId;
            $tranzactie->nr_comanda = \Illuminate\Support\Facades\Session::get('nrcomanda');
            $tranzactie->save();

            PuncteLoialitate::storePointsToDatabase($comanda->subtotal,$comanda->utilizator_id);

            \Session::put('success', 'Payment success');
            return Redirect::to('/cos-cumparaturi/' . \Illuminate\Support\Facades\Session::get('idcos') . '/checkout-page')->with(['succes'=>'Plata cu succes']);

        }

        $comanda->update(['status'=>'Neaprobata']);
        \Session::put('error', 'Payment failed');
        return Redirect::to('/');
    }

}
