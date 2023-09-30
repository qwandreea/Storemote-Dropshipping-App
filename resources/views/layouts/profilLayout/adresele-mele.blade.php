@extends('layouts.profilLayout.sidebar_profil')
@section('content-profil')
    <meta name="_token" content="{!! csrf_token() !!}" />
    <div class="container" style="list-style: none;">
        <div class="col-md-10" id="DIVID" style="background-color: white; text-align: center">
            <div class="row">
                <h2>Adresele mele</h2>
                @if($adrese->isEmpty())
                    <h3>Nu aveti o adresa asociata profilului dumneavoastra</h3>
                @else
                    <?php $count = 1; ?>
                    <table class="table">
                        <thead class="thead-dark">
                        <tr style="color: white">
                            <th scope="col">#</th>
                            <th scope="col">Adresa</th>
                            <th scope="col">Cod postal</th>
                            <th scope="col">Oras</th>
                            <th scope="col">Regiune</th>
                            <th scope="col">Operatii</th>
                        </tr>
                        </thead>
                        <tbody style="text-align: left;">
                        @foreach($adrese as $adresa)
                        <tr class="gradeX" >

                                <th scope="row"><?php echo $count; ?></th>
                                <th scope="col">
                                    <input type="text" style="width: 100%; background-color: white; color: black" disabled class="input" id="adresa{{$adresa->id}}" required
                                           value="{{$adresa->adresa}}"/></th>
                                <th scope="col">{{$adresa->cod_postal}}</th>
                                <th scope="col">{{$adresa->oras}}</th>
                                <th scope="col">{{$adresa->regiune}}</th>
                                <th scope="col">
                                    <input type="hidden" id="idUser{{$adresa->id}}" value="{{auth()->user()->id}}">
                                    <a id="modifica-adresa" data="{{$adresa->id}}" class="btn btn-warning modifica-adresa{{$adresa->id}}">Modifica</a>
                                    <a id="salveaza-adresa{{ $adresa->id }}" class="btn btn-success" style="display:none">Salveaza</a>
                                    <a id="sterge-adresa" data="{{$adresa->id}}" class="btn btn-danger">Sterge</a>
                                </th>
                            <?php $count++;?>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
