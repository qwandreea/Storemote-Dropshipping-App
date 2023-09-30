<?php

use App\Http\Controllers\Controller;

$categorie = Controller::categoriiPrincipale();
$subcategorie = Controller::subcategoriiCategorii();
$nrElementeCos = Controller::nrElementeCos();
?>
<nav class="navigation-bar navbar navbar-inverse  navbar-fixed-top" style="background-color: black;">
    <!--TOP INCEPUT-->
    <div class="navigation-logo">
        <a style="text-decoration: none;" href="{{ url('/') }}">
            <p class="shine">STOREMOTE</p>
        </a>
    </div>
    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbarHeaderCollapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <div class="container-fluid nav-custom-container navbarHeaderCollapse navbar-collapse collapse menubar"
         style="z-index: 950; width: 100%;">
        <ul class="nav navbar-nav nav-custom">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a>Magazin</a>
                <div class="submenu-1">
                    <ul>
                        @foreach($categorie as $cat)
                            <li class="lihover"><a
                                    href="{{ asset("/produse/".$cat->adr_url) }}">{{ $cat->denumire }}</a><i
                                    class="fa fa-angle-right"></i>
                                <div class="submenu-2">
                                    <ul>
                                        @foreach($subcategorie as $subcat)
                                            @if($subcat->id_parinte==$cat->id)
                                                <li>
                                                    <a href="{{ asset('/produse/subcategorie/'.$subcat->adr_url) }}">{{ $subcat->denumire }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li><a href="{{ asset(url('/produse')) }}">Toate produsele</a></li>
            <li><a href="{{ asset(url('/sectiune-inchiriere')) }}">Sectiune inchiriere</a></li>
            <li><a href="{{ url('forum') }}">Forum</a></li>
            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </li>
            <div class="col-sm-3 col-md-3" style="width:50vh;">
                <form class="navbar-form" role="search" action="{{ route('search') }}">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Caută produs.." name="search"
                               style=" width:35vh; margin-top:-2%;" required>
                        <div class="input-group-btn">
                            <button class="btn btn-default btninfo" type="submit" style="margin-top:-17%; height:34px;">
                                <i
                                    class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            @guest
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/') }}">Home</a>
                    @else

                        <li>
                            <a id="ex4" href="/cos-de-cumparaturi">
                        <span class="p1 fa-stack fa-2x has-badge" data-count="{{ $nrElementeCos }}">
                             <i class="p3 fa fa-shopping-cart fa-stack-1x xfa-inverse" data-count="4b"></i>
                        </span>
                            </a>
                        </li>

                        <li>
                            <button class="button-authenticate"><a id="aa" href="{{ route('login') }}">Autentificare</a>
                            </button>
                        </li>
                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                        <li>
                            <button class="button-authenticate"><a id="aa"
                                                                   href="{{ route('register') }}">Înregistrare</a>
                            </button>
                        </li>
                    @endauth
                @endif
            @else
                <li><a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="20"
                             viewBox="0 0 172 172" style=" fill:#000000;">
                            <g transform="">
                                <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt"
                                   stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray=""
                                   stroke-dashoffset="0" font-family="none" font-size="none"
                                   style="mix-blend-mode: normal">
                                    <path d="M0,172v-172h172v172z" fill="#191919"></path>
                                    <path d="" fill="none"></path>
                                    <g fill="#886f4a">
                                        <path
                                            d="M86,0c-7.59219,0 -13.76,6.16781 -13.76,13.76c0,7.59219 6.16781,13.76 13.76,13.76c7.59219,0 13.76,-6.16781 13.76,-13.76c0,-7.59219 -6.16781,-13.76 -13.76,-13.76zM66.65,20.9625c-15.72187,6.73219 -25.37,21.88969 -25.37,40.9575c0,37.84 -13.07469,47.34031 -20.855,52.9975c-3.45344,2.49938 -6.665,4.82406 -6.665,8.9225c0,14.47219 21.6075,20.64 72.24,20.64c50.6325,0 72.24,-6.16781 72.24,-20.64c0,-4.09844 -3.21156,-6.42312 -6.665,-8.9225c-7.78031,-5.65719 -20.855,-15.1575 -20.855,-52.9975c0,-19.12156 -9.63469,-34.23875 -25.37,-40.9575c-2.94281,7.82063 -10.52156,13.4375 -19.35,13.4375c-8.82844,0 -16.40719,-5.63031 -19.35,-13.4375zM65.36,150.93c0,0.13438 0,0.29563 0,0.43c0,11.38156 9.25844,20.64 20.64,20.64c11.38156,0 20.64,-9.25844 20.64,-20.64c0,-0.13437 0,-0.29562 0,-0.43c-6.47687,0.26875 -13.35687,0.43 -20.64,0.43c-7.28312,0 -14.16312,-0.16125 -20.64,-0.43z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </a></li>

                <li>
                    <a id="ex4" href="/cos-de-cumparaturi">
                        <span class="p1 fa-stack fa-2x has-badge" data-count="{{ $nrElementeCos }}">
                             <i class="p3 fa fa-shopping-cart fa-stack-1x xfa-inverse" data-count="4b"></i>
                        </span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                       style="position: relative; padding-top: 15px; padding-left: 50px;">
                        <img src="/uploads/avatar/{{Auth::user()->imagine}}"
                             style="width: 35px; position: absolute; top:10px; left:5px; border-radius: 50%;">
                        {{Auth::user()->nume.' '.Auth::user()->prenume }} <span
                            class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <ul class="ul-dropdown">
                            <li><a class="dropdown-item" href="{{ url('/profil') }}" style="color: black;">
                                    {{ __('Profil') }}
                                </a></li>
                            <hr>
                            <li><a class="dropdown-item" href="{{ url('/comenzile-mele/'.auth()->user()->id) }}" style="color: black;">
                                    {{ __('Comenzile mele') }}
                                </a></li>
                            <hr>
                            <li><a class="dropdown-item" href="{{ url('/adresele-mele/'.auth()->user()->id) }}"
                                   style="color: black;">
                                    {{ __('Adresele mele') }}
                                </a></li>
                            <hr>
                            <li><a class="dropdown-item" href="{{ url('/cupoanele-mele/'.auth()->user()->id) }}" style="color: black;">
                                    {{ __('Cupoanele mele') }}
                                </a></li>
                            <hr>
                            <li><a class="dropdown-item" style="color: black;"
                                   href="{{ url('/solicitarile-mele/'.auth()->user()->id) }}">
                                    {{ __('Solicitari inchiriere') }}
                                </a></li>
                            <hr>
                            <li><a href="{{ url('/recenziile-mele/'.auth()->user()->id) }}" class="dropdown-item"
                                   style="color: black;">
                                    {{ __('Recenziile mele') }}
                                </a></li>
                            <hr>
                            <li><a class="dropdown-item" href="{{ route('logout') }}" style="color: black;"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Iesire') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>


                    </div>
                </li>
        </ul>
        @endguest
    </div>
    <div style="background-color: white; width: 100%; height: 1px;"></div>
</nav>
