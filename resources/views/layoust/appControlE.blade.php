<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Control Electoral EC') }}</title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('front/front.css') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo/favicon.png') }}">
</head>

<body>
    <div id="main">
        <!-- Authentication Links -->
        @guest
            @if (Route::has('login'))
                Iniciar
            @endif
        @else
            Bienvenido  {{ Auth::user()->name }}
        @endguest
        
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('front/js/app.js') }}"></script>
</body>
</html>