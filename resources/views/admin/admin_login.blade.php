<!DOCTYPE html>
<html lang="en">

<head>
    <title>Administrator</title><meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset('css/css_backend/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/css_backend/bootstrap-responsive.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/css_backend/matrix-login.css')}}" />
    <link href="{{asset('font/font_backend/css/font-awesome.css" rel="stylesheet')}}" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

</head>
<body>
<div id="loginbox">
    <form id="loginform" class="form-vertical" method="post" action="{{url('admin')}}"> {{csrf_field()}}



        <div class="control-group normal_text"> <h3>Panou adiminstrator</h3></div>

        @if(Session::has('admin_error_login'))
            <div class="alert alert-error alert-dismissible show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>{!! session('admin_error_login') !!}</strong>
            </div>
        @endif

        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="email" name="email" placeholder="Nume utilizator" />
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" name="password" placeholder="Parola" />
                </div>
            </div>
        </div>
        <div class="form-actions">
            <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Pierdut parola?</a></span>
            <span class="pull-right"><input type="submit" class="btn btn-success" value="Autentificare"></input></span>
        </div>
    </form>
    <form id="recoverform" action="#" class="form-vertical">
        <p class="normal_text">Introduceti email-ul si va vom trimite instructiuni de resetare</p>

        <div class="controls">
            <div class="main_input_box">
                <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text" placeholder="Adresa e-mail" />
            </div>
        </div>

        <div class="form-actions">
            <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo;Inapoi la autentificare</a></span>
            <span class="pull-right"><a class="btn btn-info">Recuperare</a></span>
        </div>
    </form>
</div>

<script src="{{ asset('js/js_backend/jquery.min.js') }}"></script>
<script src="{{ asset('js/js_backend/matrix.login.js') }}"></script>
<script src="{{ asset('js/js_backend/bootstrap.min.js') }}"></script>
</body>

</html>
