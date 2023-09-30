@extends('layouts.adminLayout.admin_page')
@section('content')
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <input type="hidden" value="{{ $comanda->id }}" id="idComanda">
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"><a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a
                    href="#" class="current">Widgets</a></div>
            <h1>Comanda {{ $comanda->nr_comanda }}</h1>
        </div>

        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span6">
                    <div class="widget-box">
                        <p style="text-align: center; font-size: medium;  padding-top: 10px;">Lista produselor</p>
                        @if($comanda->produsecos)
                            @foreach($comanda->produsecos as $produs)
                                <div class="widget-box collapsible">
                                    <div class="widget-title"><a href="#collapseOne" data-toggle="collapse"> <span
                                                class="icon"><i
                                                    class="icon-arrow-right"></i></span>
                                            <h5>Cod produs: <strong>{{ $produs->produs->cod_produs }}</strong></h5>
                                        </a>
                                    </div>
                                    <div class="collapse in" id="collapseOne">
                                        <div class="widget-content"><strong>Denumire
                                                produs:</strong> {{ $produs->produs->denumire }}
                                            <br>
                                            <strong>Cantitate:</strong> {{ $produs->cantitate }}
                                            <br>
                                            <strong>Pret:</strong> {{ $produs->produs->pret_unitar }} RON
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if($comanda->produseinchiriate)
                            @foreach($comanda->produseinchiriate as $produs)
                                <div class="widget-box collapsible">
                                    <div class="widget-title"><a href="#collapseOne" data-toggle="collapse"> <span
                                                class="icon"><i
                                                    class="icon-arrow-right"></i></span>
                                            <h5>Cod produs: <strong>{{ $produs->produs->cod_produs }}</strong></h5>
                                        </a>
                                    </div>
                                    <div class="collapse in" id="collapseOne">
                                        <div class="widget-content"><strong>Denumire
                                                produs:</strong> {{ $produs->produs->denumire }}
                                            <br>
                                            <strong>Cantitate:</strong> {{ $produs->cantitate }}
                                            <br>
                                            <strong>Data inceput:</strong> {{ $produs->data_inceput }}
                                            <br>
                                            <strong>Data returnare:</strong> {{ $produs->data_sfarsit }}
                                            <br>
                                            <strong>Subtotal:</strong> {{ $produs->subtotal }} RON
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="span6">
                    <div class="widget-box">
                        <div class="widget-title"><span class="icon"><i class="icon-info-sign"></i></span>
                            <h4>Detalii comanda</h4>
                        </div>
                        <div class="widget-content nopadding">
                            <div class="new-update clearfix"><i class="icon-ok-sign"></i>
                                <div class="update-done" style="font-size: small">Data plasarii:
                                    <strong>{{ $comanda->created_at->toDateString() }}</strong></div>
                                <br>
                                <div class="update-done" style="font-size: small">Modalitatea de plata:
                                    <strong>{{ $comanda->modalitate_plata }}</strong></div>
                                <br>
                                <div class="update-done" style="font-size: small">Subtotal:
                                    <strong>{{ $comanda->subtotal }} RON</strong></div>
                                <br>
                                <div class="update-done" style="font-size: small">Taxa: <strong>{{ $comanda->taxa }}
                                        RON</strong></div>
                                <br>
                                <div class="update-done" style="font-size: small">Total: <strong>{{ $comanda->total}}
                                        RON</strong></div>
                                <br>
                                <div class="update-done" style="font-size: small">Status: <strong>{{ $comanda->status}}
                                    </strong></div>
                                <hr>
                                <div class="update-done" style="font-size: small"><strong>Status</strong></div>
                                <br>
                                <select id="status-comanda">
                                    <option selected disabled>{{ $comanda->status }}</option>
                                    @if($comanda->status === 'In procesare')
                                        <option value="In depozit">In depozit</option>
                                        <option value="Livrata">Livrata</option>
                                    @endif
                                    @if($comanda->status === 'Platita')
                                        <option value="In procesare">In procesare</option>
                                        <option value="In depozit">In depozit</option>
                                        <option value="Livrata">Livrata</option>
                                    @endif
                                    @if($comanda->status === 'In depozit')
                                        <option value="Livrata">Livrata</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="widget-box">
                        <div class="widget-title">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab1">Client</a></li>
                                <li><a data-toggle="tab" href="#tab2">Adresa de livrare</a></li>
                                <li><a data-toggle="tab" href="#tab3">Tranzactie</a></li>
                            </ul>
                        </div>

                        <div class="widget-content tab-content">
                            <div id="tab1" class="tab-pane active">
                                <p>
                                    <strong>Nume: </strong>{{ $comanda->utilizator->nume }} {{   $comanda->utilizator->prenume }}
                                </p>
                                <p><strong>Telefon</strong> +4{{ $comanda->utilizator->telefon }}</p>
                                <p><strong>Adresa de email: </strong>{{ $comanda->utilizator->email }}</p>
                            </div>

                            <div id="tab2" class="tab-pane">
                                <?php $adresa = $comanda->adresa()->withTrashed()->first(); ?>
                                <p><strong>Adresa </strong>{{ $adresa->adresa }}</p>
                                <p><strong>Oras </strong>{{ $adresa->oras }}</p>
                                <p><strong>Regiune </strong>{{ $adresa->regiune }}</p>
                                <p><strong>Cod postal </strong>{{ $adresa->cod_postal }}</p>
                            </div>

                            <div id="tab3" class="tab-pane">
                                @if($comanda->tranzactie)
                                    <p><strong>PayId: </strong>{{ $comanda->tranzactie->payid }}</p>
                                    <p><strong>TranzactieId: </strong>{{ $comanda->tranzactie->tranzactie_id }}</p>
                                @else
                                    <p>Nu exista tranzactie online pentru aceasta comanda</p>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
