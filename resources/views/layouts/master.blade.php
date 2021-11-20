<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>

    <!-- Global stylesheets -->
    <link href="{{asset('public/fonts.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/global_assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/assets/css/core.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('public/assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->



    <link href="{{asset('public/custom.css')}}" rel="stylesheet" type="text/css">

    @yield('style')

</head>

<body class="navbar-top {{ Session::get('sidebarState') }}">

@include('shared.header')



<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">
        @include('shared.aside')

        <!-- Main content -->
        <div class="content-wrapper">
            <!-- Content area -->
            <div class="content">
                @yield('content')

                @yield('box')

                @include('shared.footer')
            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->


<!-- Core JS files -->
<!--Delete Method Submit Form -->
<form id="myDeleteForm" action="" method="POST">
    @method('DELETE')
    @csrf
</form>
<!--Delete Method Submit Form -->

<!-- Core JS files -->
<script type="text/javascript" src="{{asset('public/global_assets/js/plugins/loaders/pace.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/global_assets/js/core/libraries/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/global_assets/js/core/libraries/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script type="text/javascript" src="{{asset('public/global_assets/js/plugins/ui/nicescroll.min.js')}}"></script>

<script type="text/javascript" src="{{asset('public/assets/js/app.js')}}"></script>
<script type="text/javascript" src="{{asset('public/global_assets/js/demo_pages/layout_fixed_custom.js')}}"></script>

<script type="text/javascript" src="{{asset('public/global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/global_assets/js/plugins/tables/datatables/extensions/select.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/global_assets/js/plugins/ui/moment/datetime-moment.js')}}"></script>
<script type="text/javascript" src="{{asset('public/global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('public/global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/global_assets/js/plugins/notifications/noty.min.js')}}"></script>
<!-- /theme JS files -->


<script type="text/javascript" src="{{asset('public/custom.js')}}"></script>



@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script type="text/javascript">
            $(function () {
                new Noty({
                    theme: 'limitless',
                    layout: 'topRight',
                    timeout: 10000,
                    text: "{{$error}}",
                    type: 'error',
                    closeWith: ['click']
                }).show();
            });
        </script>
    @endforeach
@endif

@if(Session::has('message'))
    <script type="text/javascript">
        $(function () {
            new Noty({
                theme: 'limitless',
                layout: 'topRight',
                timeout: 5000,
                text: "{{Session::get('message')}}",
                type: "{{Session::get('alert-type')}}",
                closeWith: ['click']
            }).show();
        });
    </script>
@endif

<script type="text/javascript">


    $(function () {
        $.fn.dataTable.moment( 'DD/MM/YYYY');<!--Datatable Date Sorting Plugin-->

        $.extend(
            $.fn.dataTable.defaults, {
                responsive: true,
                autoWidth: false,
                dom: 'Blfrtip',
                buttons: [
                    'colvis',
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                       // footer: true,
                        exportOptions: {
                            columns: ':visible'
                        },
                        //orientation: 'landscape',
                        //pageSize: 'LEGAL'
                    },
                    {
                        extend: 'print',
                        //footer: true,
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function ( win ) {
                            $(win.document.body).css( 'font-size', '10pt' );
                            $(win.document.body).find( 'table' ).addClass( 'compact' ).css( 'font-size', 'inherit' );
                            $(win.document.body).find('th').addClass('p-td');
                            $(win.document.body).find('td').addClass('p-td');
                        }
                    }
                ],
                lengthMenu: [[10, 15, 25, 50, 100, -1], [10, 15, 25, 50, 100, "All"]],
                iDisplayLength: 100,
                order: [],
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': '→', 'previous': '←' }
                },
                drawCallback: function () {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                }
            });

    });


    //Delete Method Submit Form
    $(function () {
        $('.delItem').click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $('#myDeleteForm').attr('action', url);
            if(confirm("Are you sure? Do you want to delete this?")){
                $('#myDeleteForm').submit();
            }
        });
    });
    //Delete Method Submit Form

</script>

@yield('script')




</body>
</html>
