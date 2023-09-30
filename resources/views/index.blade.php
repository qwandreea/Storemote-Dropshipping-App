@extends('layouts.storeLayout.storemote_page')
@section('content')
    <?php
    use App\Http\Controllers\Controller;
    $produseMostra=Controller::produseMostra();
    $informatiiContact = Controller::infoContact();
    $promotii = Controller::promotii();
    ?>
    <div id="form"></div>
    <div class="container container-fluid" style="background-color: #191919; width: auto; margin-top:0;">
        <div class="row container-inner" id="container-inner">
            <div class="col-sm-8 img-col">
                <img src="{{asset('imagini/images_frontend/home-deco.png')}}" id="home-deco" alt="Home Deco">
            </div>

            <div class="col-xs-6 text-col ">
                <div>
                    <p id="welcome-text">BUN VENIT <br> &nbsp; LA<br><span class="shine" style="padding-left: 80%;">STOREMOTE</span></p>
                    <p id="explanation">Materiale si unelte de constructii</p>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div style="background-color: black;">
        <div class="swiper-container" style="width: 100%;padding-top: 50px;padding-bottom: 50px;">
            <div class="swiper-wrapper"
                 style=" background-position: center;background-size: cover;width: 300px;height: 300px;">
                @foreach($produseMostra as $prod)
                    <div class="swiper-slide textOver"
                         data-text={{ $prod->denumire }}
                         style="background-image: url('{{ asset('/uploads/produse/'.$prod->imagine) }}');  background-size: 300px 300px;  background-repeat: no-repeat;">
            </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="banner-slider-wrap">
        <div class="banner-slider">
            @foreach($promotii as $promotie)
            <div class="slide">
                <img src="{{ asset('/uploads/admin/'.$promotie->banner) }}" alt="HomeDeco">
                <h3>{{ $promotie->titlu }}</h3>
                <h4>{{ $promotie->mesaj_promotie }}</h4>
            </div>
            @endforeach
    </div>
    <div style="background-color: black; height: 17px; width: 100%;"></div>
    <div class="opening-hours" style="background-color: #886f4a;">
        <img src="{{asset('imagini/images_frontend/renovating.jpg')}}" alt="renovare" id="opening-img">
        <h3>Disponibil</h3>
        <h3>24/7</h3>
        <p>Comandă acum</p>
    </div>
    <div style="height: 5px; background-color: black;"></div>
    <div class="row" style="background-color: black;">
        <div class="column c1">
            <h2>Contactați-ne </h2>
            <p>{{ $informatiiContact->adresa }}</p>
            <p>{{ $informatiiContact->email }}</p>
            <p>{{ $informatiiContact->telefon }}</p>
        </div>
        <div class="column col-xs-6 col-sm-4" id="column">
            <img src="{{asset('imagini/images_frontend/contactus.jpg')}}" alt="contact">
        </div>
    </div>
    <div style="height: 5px; background-color: black;"></div>
    <div id="map"></div>
    </div>
@endsection


