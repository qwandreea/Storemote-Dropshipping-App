@extends('layouts.storeLayout.storemote_page')
@section('assets')
    <link rel="stylesheet" href="{{asset('css/css_frontend/detalii-produs.css')}}"/>
@endsection
@section('content')
    <?php
    use App\Produs;
    ?>
    <div class="container container-cos">
        <h2>Cosul meu de cumparaturi</h2>

        @if(Session::has('modificare_cu_succes'))
            <div class="alert alert-success alert-dismissible show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <strong>{!! session('modificare_cu_succes') !!}</strong>
            </div>
        @endif

        @if(Session::has('eroare'))
            <div class="alert alert-danger alert-dismissible show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <strong>{!! session('eroare') !!}</strong>
            </div>
        @endif

        <?php $total = 0; ?>

{{--ACHIZITIE--}}
        @if( $produse !== null)
        <table id="cart" class="table table-hover table-condensed">
            <thead>
            <tr style="text-align: center">
            <tr>
                <th colspan="5" style="text-align: center; font-size: large; background-color: lightgrey">Produse de achizitie</th>
            </tr>
                <th class="header" style="width:30%">Produs</th>
                <th class="header" style="width:10%">Pret</th>
                <th class="header" style="width:15%">Cantitate</th>
                <th class="header text-center" style="width:10%;">Operatii</th>
                <th class="header" style="width:20%">Subtotal</th>
            </tr>
            </thead>
            <tbody>

            @foreach(array_combine($produse, $cantitati) as $produs=>$cantitate)
                <?php $prod = json_decode($produs); ?>
                <tr>
                    <td data-th="Produs">
                        <div class="row">
                            <div class="col-sm-2 hidden-xs"><img src="{{ asset('/uploads/produse/'.$prod->imagine) }}" alt="Produs-cos" class="img-responsive"/></div>
                            <div class="col-sm-10">
                                <h4 class="denumire">{{$prod->denumire}}</h4>
                            </div>
                        </div>
                    </td>

                    <td data-th="Pret">{{ $prod->pret_unitar }} RON</td>

                    <td data-th="Cantitate" class="butoncantitate">
                        <a class="plus" href="/cos-de-cumparaturi/plus-cantitate/{{ $prod->id }}">+</a>
                        <input type="text" class="cantitate" name="cantitate" value="{{$cantitate}}" size="2" disabled>
                        <a class="minus" href="/cos-de-cumparaturi/minus-cantitate/{{ $prod->id }}">-</a>
                    </td>

                    <td class="actions text-center" data-th="">
                        <a href="/cos-de-cumparaturi/sterge-produs/{{ $prod->id }}" class="btn btn-danger"
                           style="width: 10rem; height:3rem;">Sterge</a>
                    </td>
                    <td data-th="Subtotal">{{ $prod->pret_unitar * $cantitate }} RON</td>
                    <?php $total+=$prod->pret_unitar * $cantitate; ?>
                </tr>
                @endforeach
            @endif
            </tbody>
        </table>
{{--ENDACHIZITIE--}}

{{--INCHIRIATE--}}
            @if(!empty($inchiriate))
                <table id="cart" class="table table-hover table-condensed">
                <thead>
                <tr>
                    <th colspan="5" style="text-align: center; font-size: large; background-color: lightgrey">Produse Inchiriate</th>
                </tr>
                <th class="header" style="width:30%">Produs</th>
                <th class="header" style="width:5%">Cantitate</th>
                <th class="header" style="width:30%">Data inceput - Data returnare</th>
                <th class="header text-center" style="width:0%;">Operatii</th>
                <th class="header" style="width:20%">Subtotal</th>
                </tr>
                </thead>

                <tbody>
                @foreach($inchiriate as $inchiriat)
                    <?php $prod = Produs::where('id',$inchiriat->id)->first(); ?>
                    <tr>
                        <td data-th="Produs">
                            <div class="row">
                                <div class="col-sm-2 hidden-xs"><img src="{{ asset('/uploads/produse/'.$prod->imagine) }}" alt="Produs-cos" class="img-responsive"/></div>
                                <div class="col-sm-10">
                                    <h4 class="denumire">{{$prod->denumire}}</h4>
                                </div>
                            </div>
                        </td>
                        <td data-th="Cantitate">{{ $inchiriat->cantitate }}</td>
                        <td data-th="Data">{{ $inchiriat->data_inceput }} - {{ $inchiriat->data_sfarsit }}</td>
                        <td class="actions text-center" >
                            <a href="/cos-de-cumparaturi/sterge-produs-inchiriat/{{ $prod->id }}" class="btn btn-danger"
                               style="width: 10rem; height:3rem;">Sterge</a>
                        </td>
                        <td data-th="Subtotal">{{ $inchiriat->subtotal }} RON</td>
                        <?php $total+=$inchiriat->subtotal; ?>
                    </tr>
                @endforeach
                </tbody>
                </table>
                @endif
{{--ENDINCHIRIATE--}}

{{--FOOTER--}}
            @if(!Empty($cosCumparaturi))
        <table id="cart" class="table table-hover table-condensed">
            <tfoot>
            <tr class="visible-xs">
                <td class="text-center"><strong>Total <?php echo $total;?></strong> RON</td>
            </tr>
            <tr>
                <td><a href="/produse" class="btn btn-warning" style="font-size: 16px; height: 6rem; padding-top: 0"><i
                            class="fa fa-angle-left"></i> Continua cumparaturile</a></td>
                <td colspan="2" class="hidden-xs"></td>
                <td class="hidden-xs text-center">
                    <h3 style="color:black; text-decoration: underline">Subtotal <strong><?php echo $total;?></strong> RON</h3>

                </td>

                <td><a href="{{ url('/cos-cumparaturi/'.$cosCumparaturi->id.'/checkout-page') }}" class="btn btn-success btn-block" style="font-size: 16px; height: 6rem; padding-top: 0">Checkout
                        <i class="fa fa-angle-right"></i></a></td>
                    @endif
            </tr>
            </tfoot>
        </table>
{{--ENDFOOTER--}}


            @if($produse === null)
            <div class="text-center cos-gol">  {{ $mesaj }}
            <img src="{{ asset('/imagini/images_frontend/empty-cart.png') }}">
            </div>
            @endif

    </div>
@endsection
