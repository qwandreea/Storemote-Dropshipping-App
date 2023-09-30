@extends('layouts.storeLayout.storemote_page')
@section('assets')
    <link rel="stylesheet" href="{{asset('css/css_frontend/detalii-produs.css')}}"/>
@endsection

@section('content')
    <section style="list-style: none;">
        <div class="prod_page">
            <div class="container">

                <?php $linkColor = "#555555"; ?>
                <form name="adaugaCosForm" id="adaugaCosForm" action="{{ url('/adauga-in-cos') }}"
                      method="post"> {{ csrf_field() }}

                    <input type="hidden" name="id_produs" value="{{ $detaliiProdus->id }}">
                    <input type="hidden" name="pret_produs" value="{{ $detaliiProdus->pret_unitar }}">
                    <!-- +cantitatea mai jos -->

                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="produs-imagine">
                                    <img src="{{ asset('/uploads/produse/'.$detaliiProdus->imagine) }}"
                                         class="img-responsive" style="width: 400px; height: 400px; margin-top: -10%;"/>
                                </div>

                            </div>

                            <div class="col-md-8 col-sm-8 col-xs-12 product-box">
                                <div class="product_detail_view">
                                    <div class="produs-denumire">
                                        {{ $detaliiProdus->denumire }}
                                        <span class="produs-categorie">
	                                       {{ $detaliiProdus->categorie->denumire }}
                                        <div>
                                             <span id="valabilitate-stoc">
                                                     @if($detaliiProdus->specificatie->stoc > 0 )
                                                     <p id="instoc">In stoc</p>

                                                 @elseif($detaliiProdus->specificatie->stoc === 0 )
                                                     <p id="nustoc">Produsul nu este in stoc</p>
                                                 @endif
	                                        </span>
                                        </div>
	                                </span>
                                    </div>

                                    <div class="produs-pret">
                                        {{ $detaliiProdus->pret_unitar }} RON
                                    </div>

                                    <div class="color_quantity">
                                        @if($detaliiProdus->specificatie->stoc > 0 || $detaliiProdus->specificatie->stoc === null)
                                            <div class="color">
                                                <button type="submit" href="/adauga-in-cos"
                                                        class="btn btn-warning btn-lg">
                                                    <span class="glyphicon glyphicon-shopping-cart"></span> Adauga in
                                                    cos
                                                </button>
                                            </div>
                                    <div class="quantity" style="margin-left: 0">
                                        <input type="number" name="cantitate" min="1"
                                               max="{{ $detaliiProdus->specificatie->stoc }}" step="1"
                                               value="1"/>
                                    </div>
                                    </div>

                                        @else
                                            <div class="color">
                                                <button href="#" class="btn btn-warning btn-lg" disabled>
                                                    <span class="glyphicon glyphicon-shopping-cart"></span> Indisponibil
                                                </button>
                                            </div>
                                            <div class="quantity">
                                                <input type="number" name="cantitate" min="1" max="9" step="1"
                                                       value="1">
                                            </div>
                                        @endif

                                        {{--                                        <div class="favorite">--}}
                                        {{--                                            <a id="favorite-text" href="/">--}}
                                        {{--                                                <div id="addFavorite">--}}
                                        {{--                                                    <img src="{{asset('imagini/images_frontend/wishlist.png')}}"--}}
                                        {{--                                                         alt="contact">--}}
                                        {{--                                                </div>--}}
                                        {{--                                                Adaugare favorite--}}
                                        {{--                                            </a>--}}
                                        {{--                                        </div>--}}
                                        <section id="form-review"></section>


                                    <div class="col-md-12">

                                        <ul class="nav nav-tabs tabs-3 red" role="tablist">
                                            <li class="nav-item active">
                                                <a class="nav-link active" data-toggle="tab" href="#furnizor"
                                                   role="tab">Furnizor</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#descriere"
                                                   role="tab">Descriere</a>
                                            </li>
                                            @if($detaliiProdus->pret_inchiriere_ora !== null)
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#pretInchiriere"
                                                       role="tab">Pret
                                                        inchiriere</a>
                                                </li>
                                            @endif
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#review"
                                                   role="tab">Review-uri</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content card">
                                            <div class="tab-pane fade in show active" id="furnizor" role="tabpanel">
                                                <br>
                                                {{ $detaliiProdus->furnizor->denumire_furnizor }}
                                            </div>

                                            <div class="tab-pane fade" id="descriere" role="tabpanel">
                                                <p id="text"><strong>Cod
                                                        produs: </strong>{{  $detaliiProdus->cod_produs }}
                                                </p>
                                                <p id="text"><strong> Informatii
                                                        generale: </strong> {{  $detaliiProdus->categorie->descriere }}
                                                </p>
                                                <p id="text">
                                                    <strong>Descriere: </strong>{{  $detaliiProdus->descriere }}
                                                </p>
                                                <p id="text"><strong>Specificatii Tehnice:</strong></p>
                                                <p id="text">
                                                    Culoare: {{ $detaliiProdus->specificatie->culoare }}
                                                </p>
                                                <p id="text">
                                                    Material: {{ $detaliiProdus->specificatie->material }}
                                                </p>
                                                <p id="text">
                                                    Greutate: {{ $detaliiProdus->specificatie->greutate }}  {{ $detaliiProdus->specificatie->unitate_masura_greutate }}
                                                </p>
                                                @if($detaliiProdus->specificatie->lungime !== null)
                                                    <p id="text">
                                                        Lungime: {{ $detaliiProdus->specificatie->lungime }}   {{ $detaliiProdus->specificatie->unitate_masura }}
                                                    </p>
                                                @endif


                                                @if($detaliiProdus->specificatie->latime !== null)
                                                    <p id="text">
                                                        Latime: {{ $detaliiProdus->specificatie->latime }}   {{ $detaliiProdus->specificatie->unitate_masura }}
                                                    </p>
                                                @endif

                                                @if($detaliiProdus->specificatie->inaltime !== null)
                                                    <p id="text">
                                                        Inaltime: {{ $detaliiProdus->specificatie->inaltime }}   {{ $detaliiProdus->specificatie->unitate_masura }}
                                                    </p>
                                                @endif

                                            </div>

                                            <div class="tab-pane fade" id="pretInchiriere" role="tabpanel">
                                                <p id="text">Pret inchiriere pe
                                                    ora: {{ $detaliiProdus->pret_inchiriere_ora }} RON</p>
                                                <p id="text">Pret inchiriere pe
                                                    zi: {{ $detaliiProdus->pret_inchiriere_zi }}
                                                    RON</p>
                                            </div>

                                            <div class="tab-pane fade" id="review" role="tabpanel">
                                                @if($recenzii->isEmpty())
                                                    <div><span class="stars-container stars-0">★★★★★</span></div>
                                                    <p id="text"> Produsul nu are inca recenzii. Fii primul care
                                                        acorda </p>
                                                @else
                                                    @foreach($recenzii as $recenzie)
                                                        <div>
                                                            <img
                                                                src="{{ asset('/uploads/avatar/'.$recenzie->utilizator->imagine) }}"
                                                                class="avatar img-circle" alt="avatar">
                                                            <p id="text">{{ $recenzie->utilizator->prenume }}:
                                                                <strong>{{ $recenzie->titlu }}</strong></p>
                                                        </div>
                                                        <div><span class="stars-container stars-{{ $recenzie->nota }}">★★★★★</span>
                                                        </div>
                                                        <p id="text">{{ $recenzie->comentariu }} </p>
                                                        <hr/>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <h2>Adauga recenzie</h2>

        @guest
            <div style="text-align: center">
                <p style="color: black; font-size: 20px;">Trebuie sa fiti autentificat</p>
            </div>
        @endguest


        @auth
            <div class="form-review">
                <form action="{{ url('adauga-recenzie/'.$detaliiProdus->id) }}" method="post"> {{ csrf_field() }}
                    <div class="row">
                        <div class="col-25">
                            <label for="country">Titlu</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="titlu" name="titlu" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="country">Nota</label>
                        </div>
                        <div class="col-75">
                            <select id="country" name="nota">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5" selected>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="subject">Comentariu</label>
                        </div>
                        <div class="col-75">
                        <textarea id="subject" name="comentariu" placeholder="Scrie comentariu.."
                                  style="height:200px" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <input id="add-review" type="submit" value="Adauga">
                    </div>
                </form>
            </div>
        @endauth

        <h2>Produse asociate</h2>
        @if($numarAsociate !== 0)
            <div class="produse-asociate">
                <div id="produse-asociate-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php $nr = 1; ?>
                        @foreach($produseAsociate->chunk(3) as $chunk3)
                            <div <?php if($nr === 1) { ?> class="item active" <?php } else { ?> class="item" <?php }?>>
                                @foreach($chunk3 as $produs)
                                    <form action="{{ url('/adauga-in-cos') }}" method="post"> {{ csrf_field() }}
                                        <input type="hidden" name="id_produs" value="{{ $produs->id }}">
                                        <input type="hidden" name="pret_produs" value="{{ $produs->pret_unitar }}">
                                        <input type="hidden" name="cantitate" value="1">

                                        <div class="col-sm-4">
                                            <div class="imagine-produs">
                                                <div class="element-asociat">
                                                    <div class="infoprod text-center">
                                                        <img src="{{ asset('/uploads/produse/'.$produs->imagine) }}"
                                                             alt="produse asociate"/>
                                                        <p>{{ $produs->denumire }}</p>
                                                        <p>{{ $produs->pret_unitar }} RON</p>

                                                        @if($produs->specificatie->stoc > 0 || $produs->specificatie->stoc === null)
                                                            <button type="submit" class="btn btn-warning add-to-cart"
                                                                    style="height: 5%"><i
                                                                    class="fa fa-shopping-cart"></i>Adauga in cos
                                                            </button>
                                                        @else
                                                            <button class="btn btn-warning add-to-cart" disabled><i
                                                                    class="fa fa-shopping-cart"></i>Indisponibil
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @endforeach
                            </div>
                            <?php $nr++; ?>
                        @endforeach
                    </div>

                    <a class="left produse-asociate-control" href="#produse-asociate-carousel" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="right produse-asociate-control" href="#produse-asociate-carousel" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>

                </div>
            </div>

        @else
            <div style="text-align: center">
                <p style="color: black; font-size: 20px;">Nu am gasit produse asociate</p>
            </div>
        @endif

    </section>
@endsection

