<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="icon" href="<%= BASE_URL %>favicon.ico"> -->

    <title>Control Electoral EC</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('front/front.css') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo/favicon.png') }}">
</head>

<body>
    <div id="main">
        <contacto></contacto>
    </div>
    <script src="{{ asset('front/js/app.js') }}"></script>
</body>
</html>