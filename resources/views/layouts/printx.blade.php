<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link href="{{asset('public/fonts.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/global_assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/assets/css/core.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/custom.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/printx.css')}}" rel="stylesheet" type="text/css">
</head>
<body onload="print()">
<div id="container">

    @yield('content')

    @yield('footer')

</div>
</body>
</html>