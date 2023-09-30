@extends('layouts.profilLayout.sidebar_profil')
@section('content-profil')
    <div class="container" style="list-style: none;">
        <div class="col-md-10" id="DIVID" style="background-color: white; text-align: center">
            <div class="row">
                <h2>Solicitarile mele</h2>
                @if(Session::has('modificare_cu_succes'))
                    <div class="alert alert-success alert-dismissible show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>{!! session('modificare_cu_succes') !!}</strong>
                    </div>
                @endif

                @if(! $produse_inchiriate->isEmpty())
                <?php $count = 1; ?>
                    <table class="table">
                        <thead class="thead-dark">
                        <tr style="color: white;">
                            <th scope="col">#</th>
                            <th scope="col">Produs</th>
                            <th scope="col">Data inceput - Data returnare</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Status</th>
                            <th scope="col">Operatii</th>
                        </tr>
                        </thead>
                        <tbody style="text-align: left;">
                        @foreach($produse_inchiriate as $produs_inchiriat)
                            @if($produs_inchiriat->comanda_id===null)
                            <tr>
                                <th scope="row"><?php echo $count; ?></th>
                                <td style="font-size: medium">{{ $produs_inchiriat->produs->denumire }} </td>
                                <td>{{ $produs_inchiriat->data_inceput }} <strong>-</strong> {{ $produs_inchiriat->data_sfarsit }}</td>
                                <td style="font-size: medium">{{ $produs_inchiriat->subtotal }} LEI</td>
                                <td>
                                    @switch($produs_inchiriat->status)
                                        @case('In asteptare')
                                        <div class="asteptare" style="background-color: yellow; width: auto; height: auto; border: 2px solid black; padding: 3px 3px 3px 3px; text-align: center">In asteptare</div>
                                        @break
                                        @case('Acceptat')
                                        <div class="acceptat" style="background-color: lawngreen; width: auto; height: auto; border: 2px solid black; padding: 3px 3px 3px 3px; text-align:center">Acceptat</div>
                                        @break
                                        @case('Respins')
                                        <div class="respins" style="background-color: orangered; width: auto; height: auto; border: 2px solid black; padding: 3px 3px 3px 3px; text-align: center">Respins</div>
                                        @break
                                    @endswitch
                                </td>
                                <td style="text-align: center; padding: 12px 2px 2px 2px;">
                                    @switch($produs_inchiriat->status)

                                        @case('In asteptare')
                                        <a href="{{ url('/anuleaza-solicitare/'.$produs_inchiriat->id) }}" class="btn btn-primary"
                                           style="color: white; font-size: medium; border: 1px solid black;">
                                            Anuleaza</a>
                                        @break

                                        @case('Acceptat')
                                        <a class="btn btn-success" href="{{ url('/produs-inchiriere/adauga-la-comanda/'.$produs_inchiriat->id) }}"
                                           style="color: white; width: auto; font-size: medium; border: 1px solid black;">
                                            Comanda</a>
                                        <a href="{{ url('/anuleaza-solicitare/'.$produs_inchiriat->id) }}" class="btn btn-danger"
                                           style="color: white; width:auto;font-size: medium; border: 1px solid black;">
                                            Elimina</a>

                                        @break

                                        @case('Respins')
                                        <a href="{{ url('/anuleaza-solicitare/'.$produs_inchiriat->id) }}" class="btn btn-danger"
                                           style="color: white; width:auto;font-size: medium; border: 1px solid black;">
                                            Elimina</a>
                                        @break

                                    @endswitch
                                </td>
                            </tr>
                            <?php $count++; ?>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <h3>Nu aveti solicitari</h3>
                    @endif
            </div>
        </div>
    </div>
@endsection
