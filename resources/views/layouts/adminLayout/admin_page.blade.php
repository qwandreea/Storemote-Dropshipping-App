<!DOCTYPE html>
<html lang="en">
<head>
    <title>Administrare</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/css_backend/bootstrap.min.css') }} "/>
    <link rel="stylesheet" href="{{ asset('css/css_backend/bootstrap-responsive.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/css_backend/fullcalendar.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/css_backend/matrix-style.css') }}" />
    <link rel="stylesheet" href="{{asset('css/css_backend/matrix-media.css') }}" />
    <link rel="stylesheet" href="{{ asset('font/font_backend/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/css_backend/jquery.gritter.css') }}" />
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' >
    <link rel="stylesheet" href="{{ asset('css/css_backend/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css_backend/uniform.css') }}">
    <link rel="stylesheet" href=" {{asset('css/css_backend/sweetalert2.min.css')}}">
</head>
<body>
@include('layouts.adminLayout.admin_header')

@include('layouts.adminLayout.admin_bar')

@yield('content')

@include('layouts.adminLayout.admin_footer')

<script src="{{ asset('js/js_backend/jquery.min.js') }}"></script>
<script src="{{ asset('js/js_backend/jquery.ui.custom.js') }}"></script>
<script src="{{ asset('js/js_backend/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/js_backend/jquery.uniform.js') }}"></script>
<script src="{{ asset('js/js_backend/select2.min.js') }}"></script>
<script src="{{ asset('js/js_backend/jquery.validate.js') }}"></script>
<script src="{{ asset('js/js_backend/matrix.js' ) }}"></script>
<script src="{{ asset('js/js_backend/matrix.form_validation.js') }}"></script>
<script src="{{ asset('js/js_backend/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/js_backend/matrix.tables.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/js_backend/sweetalert2.min.js') }}"></script>
<script type="text/javascript">
    function goPage (newURL) {
        if (newURL != "") {
            if (newURL == "-" ) {
                resetMenu();
            }
            else {
                document.location.href = newURL;
            }
        }
    }

    function resetMenu() {
        document.gomenu.selector.selectedIndex = 2;
    }
</script>
</body>
</html>
