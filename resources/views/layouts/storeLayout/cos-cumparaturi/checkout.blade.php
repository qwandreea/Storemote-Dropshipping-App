@extends('layouts.storeLayout.storemote_page')
@section('assets')
    <link rel="stylesheet" href="{{asset('css/css_frontend/checkout.css')}}"/>
@endsection
@section('content')
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <?php
    use App\Http\Controllers\Controller;
    $adrese = Controller::getAdresaExistenta();
    $orase = Controller::getOras();
    ?>
    <div class="container" style="list-style: none; background-position: center;">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-10 col-md-10 col-lg-12 col-xl-5 text-center p-0 mt-3 mb-2">
                <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                    <h2 id="heading">Inregistrati datele de comanda</h2>
                    <form id="msform" action='/cos-cumparaturi/{{$cosCumparaturi->id}}/checkout-comanda'
                          method="post"> {{csrf_field()}}

                        @if(Session::has('succes'))
                            <ul id="progressbar">
                                <li id="account"><strong>Adresa de livrare</strong></li>
                                <li id="payment"><strong>Review cos</strong></li>
                                <li id="personal"><strong>Modalitate de plata</strong></li>
                                <li id="confirm" class="active"><strong>Comanda</strong></li>
                            </ul>
                            <fieldset>
                                <div>{{ \Illuminate\Support\Facades\Session::get('id') }}</div>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-5">
                                            <h2 class="steps">Pasul 4 - 4</h2>
                                        </div>
                                    </div>
                                    <h3 class="purple-text text-center"><strong>SUCCESS !</strong></h3> <br>
                                    <div class="col-7 text-center">
                                        <h3 class="purple-text text-center">Comanda a fost inregistrata. Verificati
                                            starea comenzii in contul dumneavoastra</h3>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-3" style="text-align: center"><img
                                            src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/Green_tick.svg/1024px-Green_tick.svg.png"
                                            class="fit-image"></div>
                                </div>
                                <br><br>
                                <div class="row justify-content-center">
                                </div>
                            </fieldset>
                        @elseif(Session::has('error'))
                            <div class="w3-panel w3-red w3-display-container">
                            <span onclick="this.parentElement.style.display='none'"
                                  class="w3-button w3-red w3-large w3-display-topright">&times;</span>
                                <p>Plata respinsa</p>
                            </div>
                            <?php Session::forget('error');?>
                        @else

                            <ul id="progressbar">
                                <li id="account" class="active"><strong>Adresa de livrare</strong></li>
                                <li id="payment"><strong>Review cos</strong></li>
                                <li id="personal"><strong>Modalitate de plata</strong></li>
                                <li id="confirm"><strong>Comanda</strong></li>
                            </ul>

                            <fieldset id="adresa">
                                <span class="steps">Pasul 1-4: <span style="color: black">Adresa livrare</span></span>
                                <div class="form-card">
                                    <div class="row">
                                        {{--ADRESA EXISTENTA--}}
                                        <div style="padding-left: 1%">
                                            @if(auth()->user() && auth()->user()->adrese === null)
                                                <h3 style="color:#886f4a;">Folositi o adresa existenta</h3>
                                                <h3>Nu aveti adrese setate pe acest cont</h3>
                                            @elseif(auth()->user() && $adrese!==null)
                                                <select name="adresa-existenta" id="adresa-existenta">
                                                    <option disabled selected>Selectati o adresa..</option>
                                                    @foreach($adrese as $adresa)
                                                        <option value="{{$adresa->id}}">{{ $adresa->adresa }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                        </div>
                                    </div>
                                    <hr>
                                    {{--ADRESA NOUA--}}
                                    <div>
                                        <h3 style="color:#886f4a;">Adaugati o adresa noua</h3>
                                        @foreach ($errors->all() as $message)
                                            <div class="alert alert-danger"
                                                 style="color: black; text-align: center">{{ $message }}</div>
                                        @endforeach
                                        <label>Adresa: </label> <input type="text" name="adresa" id="adresafield"/>
                                        <label>Cod postal: </label> <input type="text" name="codpostal" id="codfield"/>
                                        <label>Oras: </label> <select name="oras" id="orasfield" class="oras">
                                            @foreach($orase as $oras)
                                                <option>{{$oras->denumire}}</option>
                                            @endforeach
                                        </select>
                                        <label>Regiune: </label> <select name="regiune" id="regiunefield">
                                        </select>
                                    </div>

                                </div>
                                <input type="hidden" value="{{ $cosCumparaturi->id }}" id="idCos">
                                <input type="button" name="next" class="next action-button" id="nextAdresa"
                                       value="Pasul 2"/>
                            </fieldset>

                            <fieldset id="card">
                                <span class="steps">Pasul 2-4: <span style="color: black">Previzualizare cos</span></span>
                                <div>
                                    <label for="cupon" style="padding-top: 3px">Ai un cupon? Aplica!<input type="text" name="cod-cupon" id="cod-cupon"></label>
                                    <input type="text" hidden id="valoare-cos-initiala">
                                    <input type="text" hidden id="valoare-total-cos">
                                    <p id="cod-cupon-err" style="color:red;" hidden>*codul cuponului nu corespunde*</p>
                                    <p id="cod-cupon-success" style="color:seagreen;" hidden>*cuponul a fost
                                        aplicat*</p>
                                </div>
                                <div class="form-card">
                                    <div class="row">
                                        <?php $count = 1; ?>
                                        @if(!$cosCumparaturi->detaliiCos->isEmpty())
                                            <table class="table">
                                                <thead style="text-align: center">
                                                <tr>
                                                    <td colspan="4" style="font-size: medium; background-color: tan;">
                                                        Produse achizitie
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Produs</th>
                                                    <th scope="col">Pret</th>
                                                    <th scope="col">Cantitate</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($cosCumparaturi->detaliiCos as $detalii)
                                                    <tr>
                                                        <th scope="row"><?php echo $count;?></th>
                                                        <td>{{ $detalii->produs->denumire }}</td>
                                                        <td>{{ $detalii->pret }}</td>
                                                        <td>{{ $detalii->cantitate }}</td>
                                                    </tr>
                                                    <?php $count++;?>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                        @if(!$cosCumparaturi->produseInchiriate->isEmpty())
                                            <table class="table">
                                                <thead style="text-align: center">
                                                <tr>
                                                    <td colspan="6" style="font-size: medium; background-color: tan;">
                                                        Produse inchiriate
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Produs</th>
                                                    <th scope="col">Subtotal</th>
                                                    <th scope="col">Cantitate</th>
                                                    <th scope="col">Perioada</th>
                                                    <th scope="col">Tip plata</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($cosCumparaturi->produseInchiriate as $inchiriate)
                                                    <tr>
                                                        <th scope="row"><?php echo $count;?></th>
                                                        <td>{{ $inchiriate->produs->denumire }}</td>
                                                        <td>{{ $inchiriate->subtotal }}</td>
                                                        <td>{{ $inchiriate->cantitate }}</td>
                                                        <td> {{ $inchiriate->data_inceput }}
                                                            - {{ $inchiriate->data_sfarsit }}</td>
                                                        <td>Plata pe {{$inchiriate->tip}}</td>
                                                    </tr>
                                                    <?php $count++;?>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif

                                        <table id="total" class="table table-hover table-condensed">
                                            <tfoot>
                                            <tr>
                                                <td class="hidden-xs text-center">
                                                    <h3 style="color:black; text-decoration: underline">Valore cos</h3>
                                                    <h3 style="color:black;" id="valoareCos">Val</h3>
                                                </td>
                                                <td class="hidden-xs text-center">
                                                    <h3 style="color:black; text-decoration: underline">Valoare
                                                        taxa</h3>
                                                    <h3 style="color:black;" id="valoareTaxa">Valoare taxa</h3>
                                                </td>
                                                <td class="hidden-xs text-center">
                                                    <h3 style="color:black; text-decoration: underline">Total de
                                                        plata</h3>
                                                    <h3 style="color:black;" id="totalPlata">Valoare taxa</h3>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>

                                    </div>

                                </div>
                                <input type="button" name="next" class="next action-button" value="Pasul 3"/> <input
                                    type="button" name="previous" class="previous action-button-previous"
                                    value="Pasul 1"/>
                            </fieldset>
                            <fieldset>
                                <span class="steps">Pasul 3-4: <span
                                        style="color: black">Selectati modalitatea de plata</span></span>
                                <hr>
                                <div class="form-card">
                                    <label class="label">Plata in sistem ramburs
                                        <input type="radio" checked="checked" name="plata" value="cash">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="label">Plata online
                                        <input type="radio" name="plata" value="online">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="label">Sunt de acord cu termenii si conditiile
                                        <input type="checkbox" id="termeni-conditii" name="termeni-conditii">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <input type="hidden" name="subtotal" id="comanda-subtotal">
                                <input type="hidden" name="taxa" id="comanda-taxa">
                                <input type="hidden" name="total" id="comanda-total">
                                <input type="hidden" name="cod-cupon" id="codcupon">
                                <input type="submit" name="next" class="next action-button" value="Trimite"
                                       id="trimite-submit" disabled="disabled"
                                       style="height: 5%;"/> <input
                                    type="button" name="previous" class="previous action-button-previous"
                                    value="Pasul 3"/>
                            </fieldset>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
