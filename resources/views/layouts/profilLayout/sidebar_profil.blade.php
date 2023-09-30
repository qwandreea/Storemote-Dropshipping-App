@extends('layouts.storeLayout.storemote_page')
@section('assets')
    <link rel="stylesheet" href="{{asset('css/css_frontend/profil.css')}}"/>
@endsection
@section('content')
    <div style="background-color: white; height: 5%;"></div>
    <div id="main-content" role="main">
        <div class="row" style="background-color: white;">
            <div class="col-md-3">
                <div class="card" style="width: 20rem;">
                    <div class="card-img">
                        <img src="/uploads/avatar/{{Auth::user()->imagine}}">
                        <h5 class="card-title"> {{ $profilUtilizator->calitate }}. {{$profilUtilizator->nume}} - {{ $profilUtilizator->prenume }}</h5>
                        <div>
                            <a class="btnedit" href="{{ asset(url('/profil/')) }}">Editează profilul</a>
                        </div>
                        <button class="btnedit" id="btnclose" style="display:none;" onclick=closeEdit()>Închide</button>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"> <a href="{{ url('/comenzile-mele/'.auth()->user()->id) }}" class="card-link">Comenzile mele</a></li>
                        <li class="list-group-item"> <a href="{{ url('/adresele-mele/'.auth()->user()->id) }}" class="card-link">Adresele mele</a></li>
                        <li class="list-group-item"> <a href="{{ url('/solicitarile-mele/'.auth()->user()->id) }}" class="card-link">Solicitari inchiriere</a></li>
                        <li class="list-group-item"> <a href="{{ url('/recenziile-mele/'.auth()->user()->id) }}" class="card-link">Recenziile mele</a></li>
                        <li class="list-group-item"> <a href="{{ url('/cupoanele-mele/'.auth()->user()->id) }}" class="card-link">Cupoanele mele</a></li>
                    </ul>
                </div>
            </div>
            @if(Session::has('succes'))
                <div class="alert alert-success alert-dismissible show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{!! session('succes') !!}</strong>
                </div>
            @endif

            @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{!! session('error') !!}</strong>
                </div>
            @endif

            @if(count($errors))
                <div class="form-group">
                    <div class="alert alert-danger">
                        <ul style="color: black;">
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content-profil')

        </div>
    </div>
@endsection
