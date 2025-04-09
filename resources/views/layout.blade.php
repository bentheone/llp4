<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <title>@yield('title', 'Stock System')</title>
</head>
<body>
    <div class="container">
    @yield('content')
    </div>
    <div class="footer">
        <p>&copy; Stock System</p>
    </div>
    <script src="{{ asset('app.js') }}"></script>
</body>
</html>