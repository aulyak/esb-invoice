<html>

<head>
    <title>Invoice</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>

<body class="bg-light">
    @section('sidebar')

    @show

    <div class="container">
        @yield('content')
    </div>
</body>

@stack('scripts')

</html>
