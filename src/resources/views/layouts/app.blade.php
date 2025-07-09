<!doctype html>
<html>

    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') </title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logos/logo.png') }}">
    <link href="{{ asset('assets/css/output.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/komentar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    </head>

    <body>
    <div class="w-full">
            @include('includes.navbar')

            @yield('content')
    </div>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="{{ asset('assets/js/swiper.js')}}"></script>

        <script src="{{ asset('assets/js/komentar.js')}}"></script>
    </body>

</html>
