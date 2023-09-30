<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>STOREMOTE</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/css_frontend/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css_frontend/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css_frontend/fontawesome.min.css') }}">
    @yield('assets')
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--  Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script type="text/javascript" language="javascript" src="{{ asset('js/js_backend/sweetalert2.min.js') }}"></script>


    <script type="text/javascript">
        $(window).resize(function () {
            if ($(".navbar.navbar-inverse.navbar-fixed-top").height() > 80) {
                $("html, body").css("padding-top", "60px");
                $("#welcome-text, #explanation").css("font-size", 18 + "px");
            }
        });
        $(document).ready(function () {
            $(".default_option").click(function () {
                $(".dropdown ul").addClass("active");
            });

            $(".dropdown ul li").click(function () {
                var text = $(this).text();
                $(".default_option").text(text);
                $(".dropdown ul").removeClass("active");
            });
        });
    </script>

</head>
<body>
@include('layouts.storeLayout.storemote_header')

    @yield('content')

@include('layouts.storeLayout.storemote_footer')

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAo7Ogd_yFRAfs98L9PGeugG4LM6MYs8ro&callback=initMap">
</script>
<script type="text/javascript" src="{{asset('/js/js_frontend/index.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/css_frontend/slick.css')}}">
<script type="text/javascript" src="{{asset('/js/js_frontend/slick.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/js_frontend/profil.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/js_frontend/swiper.min.js')}}"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>


<script type="text/javascript">
    $('.banner-slider').slick({
        dots: true,
        infinite: true,
        speed: 300,
        autoplay: true,
        fade: true,
        speed: 2000,
        slidesToShow: 1
    });
</script>
<script>
    var swiper = new Swiper('.swiper-container', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true,
        },
        pagination: {
            el: '.swiper-pagination',
        },
    });
</script>
</body>
</html>
