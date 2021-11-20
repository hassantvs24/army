<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link href="{{asset('public/print.css')}}" rel="stylesheet" type="text/css">
</head>
<body onload="print()">
<div id="container">

    @yield('content')

    @yield('footer')

</div>
</body>
</html>