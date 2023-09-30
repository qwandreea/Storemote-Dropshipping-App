<?php

use App\Http\Controllers\Controller;
$informatiiContact = Controller::infoContact();
?>
<div class="footer" style="list-style: none;">
    <footer style="background-color:#191919">
{{--        <div class="form-abonare" style="background-color: black;">--}}
{{--            <p>Abonați-vă la noutăți</p>--}}
{{--            <form id="form-abonare" >--}}
{{--                <input type="text" name="email-abonare" id="email-abonare" placeholder="Email">--}}
{{--                <br>--}}
{{--                <input type="submit" name="submit" value="Abonare">--}}
{{--            </form>--}}
{{--        </div>--}}
        <div id="foot-area">
            <div class="container">
                <div class="row">

                    <div class="col-md-3 col-sm-6">
                        <div class="single-footer">
                            <h3>Informații utile</h3>
                            <a href="{{ url('/despre-noi') }}">
                                <p>Despre noi</p>
                            </a>
                            <a href="{{ url('/forum') }}">
                                <p>Întrebări frecvente</p>
                            </a>
                            <a href="{{ url('/prelucrare-date') }}">
                                <p>Prelucrarea datelor cu caracter personal</p>
                            </a>
                            <a style="text-decoration:none;">
                                <p>Urmăriți-ne activitatea în mediul online</p>
                            </a>
                            <ul class="footersocial list-inline ">
                                <li><a href="#" class="fa fa-facebook img-circle"></a></li>
                                <li><a href="#" class="fa fa-linkedin img-circle"></a></li>
                                <li><a href="https://ro.pinterest.com/search/pins/?q=home%20design&rs=typed&term_meta[]=home%7Ctyped&term_meta[]=design%7Ctyped" class="fa fa-pinterest img-circle"></a></li>
                                <li><a href="#" class="fa fa-skype img-circle"></a></li>
                                <li><a href="#" class="fa fa-instagram img-circle"></a></li>
                                <li><a href="#" class="fa fa-twitter img-circle"></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6" style="list-style-type:none;">
                        <div class="single-footer">
                            <h3>Suport</h3>
                            <ul class="link-area">
                                <li><a href="{{ url('/anulare-comenzi') }}">
                                        <p>Anularea unei comenzi</p>
                                    </a></li>
                                <li><a href="https://reclamatii.anpc.ro/Reclamatie.aspx">
                                        <p>ANPC</p>
                                    </a></li>
                                <li><a href="{{ url('/termeni-conditii') }}">
                                        <p>Termeni și condiții</p>
                                    </a></li>
                                <li><a href="{{url('/metode-plata') }}">
                                        <p>Metode de plată</p>
                                    </a></li>
                                <li><a href="{{ url('politica-confidentialitate') }}">
                                        <p>Politica de confidențialitate</p>
                                    </a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="single-footer">
                            <h3>Unde ne puteți contacta</h3>
                            <p>Email: <strong>{{ $informatiiContact->email }}</strong></p>
                            <p>Skype: <strong>{{ $informatiiContact->skype }}</strong></p>
                            <p>Telefon: <strong>{{ $informatiiContact->telefon }}</strong></p>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="single-footer">
                            <h3>Acceptăm</h3>
                            <img src="{{asset('imagini/images_frontend/credit-cards.jpg')}}" class="img-rounded"
                                 alt="Carduri de credit">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </footer>

    <div>
        <section class="container" style="position: fixed; z-index: 1;">
            <button class="open-chat fa fa-envelope-open-o" onclick="openform()">Initiaza forum</button>
            <div class="open-chat-popup" id="mychat">
                <form action="{{route('forum')}}" method="post" class="form-chat" style="max-width: 500px; padding: 10px; background-color: white;"> {{ csrf_field() }}
                    <h2>Trimite pe forum</h2>
                    <label for="titlu"><b>Titlu</b></label>
                   <input type="text" name="titlu">
                    <label for="mesaj"><b>Mesaj</b></label>
                    <textarea placeholder="Lasă-ne un mesaj pe forum și vei primi răspuns curând.." name="mesaj"
                              required name="mesaj"></textarea>
                    <button type="submit" class="btn">Trimite</button>
                    <button type="button" class="btn cancel" onclick="closeform()">Închide</button>
                </form>
            </div>
        </section>
    </div>
    <div> <p style="background-color: black; color: white;">©2020 STOREMOTE.</p></div>
</div>


