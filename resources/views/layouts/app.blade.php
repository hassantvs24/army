<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <title>Ring</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Global stylesheets -->
    <link href="{{asset('public/fonts.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/global_assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/assets/css/core.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

</head>
<body class="login-container">
    @include('shared.app_nav')


    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content">

                    @if(Session::has('message'))
                        <div>
                            <div class="alert alert-info no-border">
                                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                                {{ Session::get('message') }}
                            </div>
                        </div>
                    @endif

                    @yield('content')

                    @include('shared.app_footer')
                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->


    <!-- Core JS files -->
    <script type="text/javascript" src="{{asset('public/global_assets/js/plugins/loaders/pace.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/global_assets/js/core/libraries/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/global_assets/js/core/libraries/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="{{asset('public/assets/js/app.js')}}"></script>
    <!-- /theme JS files -->

</body>
</html>
