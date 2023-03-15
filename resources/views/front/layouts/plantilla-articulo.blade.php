<!DOCTYPE html>
<html class="csstransforms csstransforms3d csstransitions" data-lt-installed="true">

<head>
    <title>Gustavo Ibarra</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="author" content="Gustavo Ibarra">
    <meta name="keywords" content="Politólogo, Activista, Comunicación, Política">
    <meta name="robots" content="all">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,700,800,400,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('blog/css/prettyPhoto.css') }}">
    <link rel="stylesheet" href="{{ asset('blog/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('blog/css/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('blog/css/stylesheet.css') }}">
</head>

<body style="overflow: hidden auto;">

    <div id="preloader" style="display: none;">
        <div id="status" style="display: none;">&nbsp;</div>
        <noscript>JavaScript is off. Please enable to view full site.</noscript>
    </div>

    <div class="wrapper">
        <div class="container">
            <!-- header-->  
            @section('header')
                @include('front.layouts.partials.header_simple')
            @show

            @yield('contenido')

            <!-- footer -->  
            @section('footer')
                @include('front.layouts.partials.footer')
            @show

        </div>
    </div>

    <script src="{{ asset ('blog/css/bootstrap/bootstrap.min.js') }}"></script> 
    <script src="{{ asset ('blog/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset ('blog/js/jquery-migrate-1.2.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('blog/js/css_browser_selector.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('blog/js/jquery.easing-1.3.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('blog/js/jquery.prettyPhoto.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('blog/js/jquery.validate.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('blog/js/jquery.address-1.5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('blog/js/jquery.isotope.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('blog/js/jquery.circliful.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('blog/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset ('blog/js/script.js') }}"></script>

</body>

</html>
