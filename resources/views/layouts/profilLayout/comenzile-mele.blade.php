@extends('layouts.profilLayout.sidebar_profil')
@section('content-profil')
    <?php
    use App\Adresa;
    ?>
    <div class="container" style="list-style: none;">
        <div class="col-md-9" id="DIVID" style="background-color: white; text-align: center">
            <div class="row">
                <h2>Comenzile mele</h2>
                @if(!$comenzi->isEmpty())
                    <table class="table">
                        <thead class="thead-dark">
                        <tr style="color: white">
                            <th scope="col">#Nr comanda</th>
                            <th scope="col">Stare</th>
                            <th scope="col">Comanda la adresa</th>
                            <th scope="col">Modalitate plata</th>
                            <th scope="col">Total</th>
                            <th scope="col">Descarca factura pdf</th>
                        </tr>
                        </thead>
                        <tbody style="text-align: left;">
                        @foreach($comenzi as $comanda)
                            <tr>
                                <th scope="row">{{ $comanda->nr_comanda }}</th>
                                <td>{{ $comanda->status }}</td>
                                <?php $adresa = Adresa::withTrashed()->where('id',$comanda->adresa_id)->first(); ?>
                                <td>{{ $adresa->adresa }} , {{ $adresa->oras }}</td>
                                <td>{{ $comanda->modalitate_plata }}</td>
                                <td>{{ $comanda->total }} RON</td>
                                @if($comanda->status == 'Livrata' || $comanda->status === 'Platita')
                                <td><a href="{{ url('/comenzile-mele/comanda/'.$comanda->id.'/factura') }}" class="btn btn-success">
                                    Factura</a></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h3>Nu ati plasat nici o comanda</h3>
                @endif
            </div>
        </div>
    </div>
@endsection
