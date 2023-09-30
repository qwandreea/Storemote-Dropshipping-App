<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        .detalii {
            text-decoration: underline;
        }

        .detalii-titlu {
            color: seagreen;
            font-style: italic;
            font-size: medium;
        }
    </style>
</head>
<body>
{{--Se verifica daca furnizorul curent are comenzi astazi--}}
<?php
use App\Adresa;
$produseFurnizor = 0;
$prodseInchiriateFurnizor = 0;
?>
@foreach($comenzi as $comanda)
    @foreach($comanda->produsecos as $produscos)
        @if($produscos->produs->furnizor_id === $furnizor->id)
            <?php $produseFurnizor++;?>
        @endif
    @endforeach
@endforeach

@foreach($comenzi as $comanda)
    @foreach($comanda->produseinchiriate as $produs)
        @if($produs->produs->furnizor_id === $furnizor->id)
            <?php $prodseInchiriateFurnizor++;?>
        @endif
    @endforeach
@endforeach

@if($produseFurnizor && $produseFurnizor === 0)
    <header style="text-align: center">
        <h2>Buna, {{ $furnizor->denumire_furnizor }}</h2>
        <h2>Nu aveti comenzi astazi:</h2>
        <hr>
    </header>
@else
    <header style="text-align: center">
        <h2>Buna, {{ $furnizor->denumire_furnizor }}</h2>
        <h2>Comenzile de astazi, {{ $data }}, sunt:</h2>
        <hr>
    </header>

    @foreach($comenzi as $comanda)
        <div class="container">
            <h3><strong>Comanda nr {{ $comanda->nr_comanda }}</strong></h3>
            <div class="detalii">
                <span class="detalii-titlu">Detaliile comenzii:</span>
                <p>Modalitate plata: {{ $comanda->modalitate_plata }}. Subtotal: {{ $comanda->subtotal }} RON.
                    Taxa:{{ $comanda->taxa }} RON. Total:{{ $comanda->total }} RON</p>
            </div>
            <div class="detalii">
            <span
                class="detalii-titlu">Persoana de contact</span> {{ $comanda->utilizator->nume }} {{ $comanda->utilizator->prenume }}
                <p>Email: {{ $comanda->utilizator->email }}. Telefon: {{ $comanda->utilizator->telefon }}</p>
            </div>
            <div class="detalii">
                <span class="detalii-titlu">Adresa de livrare</span>
                <?php $adresa = Adresa::withTrashed()->where(['id' => $comanda->adresa_id])->first();?>
                <p>{{ $adresa->adresa }}, {{ $adresa->oras }}, {{ $adresa->regiune }}
                    , {{ $adresa->cod_postal }}</p>
            </div>
            @if($comanda->tranzactie)
                <div>Observatii: Comanda a fost platita online</div>
            @endif
            @if($produseFurnizor !== 0)
                <h3>Produsele achizitionate</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <td scope="col">Cod produs</td>
                        <td scope="col">Denumire</td>
                        <td scope="col">Cantitate</td>
                        <td scope="col">Pret unitar</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comanda->produsecos as $produscos)
                        @if($produscos->produs->furnizor_id === $furnizor->id)
                            <tr>
                                <th scope="row">{{ $produscos->produs->cod_produs }}</th>
                                <td>{{ $produscos->produs->denumire }}</td>
                                <td>{{ $produscos->cantitate }}</td>
                                <td>{{ $produscos->pret }} RON</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            @endif

            @if($prodseInchiriateFurnizor!==0)
                <h3>Produsele inchiriate</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <td scope="col">Cod produs</td>
                        <td scope="col">Denumire</td>
                        <td scope="col">Data solicitare</td>
                        <td scope="col">Data returnare</td>
                        <td scope="col">Cantitate</td>
                        <td scope="col">Subtotal</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comanda->produseinchiriate as $produs)
                        @if($produs->produs->furnizor_id === $furnizor->id)
                            <tr>
                                <th scope="row">{{ $produs->produs->cod_produs }}</th>
                                <td>{{ $produs->produs->denumire }}</td>
                                <td>{{ $produs->data_inceput }}</td>
                                <td>{{ $produs->data_sfarsit }}</td>
                                <td>{{ $produs->cantitate }}</td>
                                <td>{{ $produs->subtotal }}</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            @endif
            <hr>
            @endforeach
        </div>
        @endif
</body>
</html>

