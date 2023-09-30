@extends('layouts.storeLayout.storemote_page')
@section('assets')
    <link rel="stylesheet" href="{{asset('css/css_frontend/produse.css')}}"/>

@endsection

@section('content')

    <?php
    use App\Http\Controllers\Controller;
    $categorie = Controller::categoriiPrincipale();
    $subcategorie = Controller::subcategoriiCategorii();
    $produse = Controller::produseAll();
    $furnizori = Controller::furnizoriAll();
    $specificatii = Controller::specificatiiAll();
    ?>
    <section>
        <div class="container" style="list-style: none;">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2 id="h2-custom">Filtreaza</h2>
                        <div class="panel-group category-products" id="accordian">
                            <h2 id="h2-custom">Categorii</h2>
                            <div class="panel panel-default">
                                @foreach($categorie as $cat)
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent='#accordian'
                                               data-target="#categorie{{$cat->id}}">
                                                <span class="fa fa-caret-square-o-down"></span>
                                            </a>
                                            <a href="{{"produse/".$cat->adr_url}}">
                                                {{ $cat->denumire }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="categorie{{$cat->id}}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <ul>
                                                @foreach($subcategorie as $subcat)
                                                    @if($subcat->id_parinte==$cat->id)
                                                        <li><a id="list"
                                                               href="{{"produse/subcategorie/".$subcat->adr_url}}">{{ $subcat->denumire }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="brands_products">
                            <h2 id="h2-custom">Furnizori</h2>
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    @foreach($furnizori as $furnizor)
                                        <li>
                                            <a href="/furnizor/produse/{{$furnizor->id}}">{{ $furnizor->denumire_furnizor }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="features_items">
                        <h2 class="title text-center">Toate produsele</h2>

                        @if(Session::has('eroare'))
                            <div class="alert alert-danger alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                </button>
                                <strong>{!! session('eroare') !!}</strong>
                            </div>
                        @endif

                        @foreach($produse as $produs)

                            <form action="{{ url('/adauga-in-cos') }}" method="post"> {{ csrf_field() }}
                                <input type="hidden" name="id_produs" value="{{ $produs->id }}" >
                                <input type="hidden" name="pret_produs" value="{{ $produs->pret_unitar }}">
                                <input type="hidden" name="cantitate" value="1">
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">

                                                <img src="{{ asset('/uploads/produse/'.$produs->imagine) }}"
                                                     alt="Imagine produs"/>

                                                <a href="{{"produs/".$produs->id}}" class="btndetalii btn-detalii">Vezi
                                                    detalii</a>


                                                <h2>{{ $produs->pret_unitar }} lei</h2>

                                                <p style="font-size: large">{{ $produs->denumire }}</p>
                                                <p style="font-size: medium">Cod produs <strong>{{$produs->cod_produs}}</strong></p>
                                                <p>*pretul include TVA*</p>


                                                @foreach($specificatii as $spec)
                                                    @if($spec->produs_id == $produs->id && ($spec->stoc > 0 || $spec->stoc === null ))
                                                        <button type="submit" class="btn btn-warning btn-lg">
                                                            <span class="glyphicon glyphicon-shopping-cart"></span> Adauga in cos
                                                        </button>
                                                    @elseif($spec->produs_id == $produs->id && $spec->stoc == 0)
                                                        <button href="#" class="btn btn-warning btn-lg" disabled>
                                                            <span class="glyphicon glyphicon-shopping-cart"></span> Indisponibil
                                                        </button>
                                                    @elseif($spec->produs_id == $produs->id && $spec->stoc == null)
                                                        <button type="submit" class="btn btn-warning btn-lg">
                                                            <span class="glyphicon glyphicon-shopping-cart"></span> Adauga in cos
                                                        </button>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="choose">
                                            <ul class="nav nav-pills nav-justified" style="list-style: none;">
                                                <li><a href="{{ asset('/produs/'.$produs->id."#form-review") }}"><i class="fa fa-plus-square"></i>Review</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>
@endsection
