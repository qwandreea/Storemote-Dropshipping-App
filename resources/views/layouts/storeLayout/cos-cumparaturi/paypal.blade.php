@extends('layouts.storeLayout.storemote_page')
@section('assets')
    <link rel="stylesheet" href="{{asset('css/css_frontend/checkout.css')}}"/>
@endsection
@section('content')
    <?php
        $total = \Illuminate\Support\Facades\Session::get('total');
        $taxa = \Illuminate\Support\Facades\Session::get('taxa');
        $nrcomanda = \Illuminate\Support\Facades\Session::get('nrcomanda');
        $adresaid = \Illuminate\Support\Facades\Session::get('idadresa');
        $idcos = \Illuminate\Support\Facades\Session::get('idcos');
        $iduser = \Illuminate\Support\Facades\Session::get('iduser');
        $cod_cupon = \Illuminate\Support\Facades\Session::get('cupon');
        $curs = 4.83;
        $convertRonToEuro = round($total/$curs,2);
    ?>
    <div class="container" style="list-style: none">
        <h2>Suma totala este <strong>{{ $total }} RON</strong> sau <strong>{{ $convertRonToEuro  }} EURO</strong> pentru comanda nr <strong>{{ $nrcomanda }}</strong></h2>
        <h3>Efectuati plata pentru a inregistra comanda</h3>
        <hr>
        <div class="container" style="list-style: none;">
            <form method="POST" id="payment-form"
                  action="{!! URL::to('paypal') !!}">
                {{ csrf_field() }}
                <input id="amount" type="hidden" name="amount" value="{{ $total }}">
                <input id="tax" type="hidden" name="tax" value="{{ $taxa }}">
                <input id="nrcomanda" type="hidden" name="nrcomanda" value="{{ $nrcomanda }}">
                <input id="adresaid" type="hidden" name="adresaid" value="{{ $adresaid }}">
                <input id="idcos" type="hidden" name="idcos" value="{{ $idcos }}">
                <input id="iduser" type="hidden" name="iduser" value="{{ $iduser }}">
                <input id="cupon" type="hidden" name="idcupon" value="{{ $cod_cupon }}">
                <div class="box">
                    <span class="paypal-logo">
                     <i>Pay</i><i>Pal</i>
                    </span>
                    <br/>
                    <button class="paypal-button">
                         <span class="paypal-button-title">
                            Buy now with
                        </span>
                        <span class="paypal-logo">
                            <i>Pay</i><i>Pal</i>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

