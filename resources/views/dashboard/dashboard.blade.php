@extends('layouts.master')

@section('title')
    Dashboard
@endsection
@section('content')

    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-home4"></i> Dashboard <small><i class="icon-calendar"></i> {{date('d M Y')}}</small></h4>
                <a class="heading-elements-toggle"><i class="icon-more"></i></a>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    @can('Sales Create')
                        <a href="{{route('sales.index')}}" class="btn btn-link btn-float has-text"><i class="icon-cart5 text-success"></i><span>New Sale</span></a>
                    @endcan
                    @can('Purchase Create')
                        <a href="{{route('purchase.index')}}" class="btn btn-link btn-float has-text"><i class="icon-cart text-primary"></i> <span>Purchase</span></a>
                    @endcan
                    @can('Expense List')
                        <a href="{{route('expenses.index')}}" class="btn btn-link btn-float has-text"><i class="icon-box-remove text-warning"></i> <span>Expense</span></a>
                    @endcan
                    @can('Accounts List')
                        <a href="{{route('accounts.index')}}" class="btn btn-link btn-float has-text"><i class="icon-coin-dollar text-info"></i> <span>Accounts</span></a>
                    @endcan
                    @can('Product List')
                        <a href="{{route('products.index')}}" class="btn btn-link btn-float has-text"><i class="icon-truck text-indigo"></i> <span>Stock</span></a>
                    @endcan
                    @can('Customer List')
                        <a href="{{route('customer.index')}}" class="btn btn-link btn-float has-text"><i class="icon-users4 text-green"></i> <span>Customer</span></a>
                    @endcan
                    @can('Supplier List')
                        <a href="{{route('supplier.index')}}" class="btn btn-link btn-float has-text"><i class="icon-user-plus text-purple"></i> <span>Supplier</span></a>
                    @endcan
                    @can('User List')
                        <a href="{{route('users.index')}}" class="btn btn-link btn-float has-text"><i class="icon-users text-pink"></i> <span>Users</span></a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="panel bg-teal-400">
                <div class="panel-body">
                    <div class="heading-elements">
                        <i class="icon-cart5"></i>
                    </div>
                    <h3 class="no-margin"><span id="today_sale"><i class="icon-spinner2 spinner"></i></span></h3>
                    Sales Today
                    <div class="text-muted text-size-small"><span id="customer_due"></span> Total Sales Due</div>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="panel bg-pink-400">
                <div class="panel-body">
                    <div class="heading-elements">
                        <i class="icon-cart"></i>
                    </div>
                    <h3 class="no-margin"><span id="today_purchase"><i class="icon-spinner2 spinner"></i></span></h3>
                    Purchase Today
                    <div class="text-muted text-size-small"><span id="supplier_due"></span> Total Purchase Due</div>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="panel bg-slate-400">
                <div class="panel-body">
                    <div class="heading-elements">
                        <i class="icon-box-remove"></i>
                    </div>
                    <h3 class="no-margin"><span id="today_expance"><i class="icon-spinner2 spinner"></i></span></h3>
                    Expense Today
                    <div class="text-muted text-size-small"><span id="monthly_expance"></span> Expanse this month</div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="panel bg-purple-400">
                <div class="panel-body">
                    <div class="heading-elements">
                        <i class="icon-truck"></i>
                    </div>
                    <h3 class="no-margin"><span id="stock_value"><i class="icon-spinner2 spinner"></i></span></h3>
                    Current Stock Value
                    <div class="text-muted text-size-small"><span id="stock_lower"></span> Lower stock item</div>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="panel bg-primary-400">
                <div class="panel-body">
                    <div class="heading-elements">
                        <i class="icon-calculator3"></i>
                    </div>
                    <h3 class="no-margin"><span id="ac_balance"><i class="icon-spinner2 spinner"></i></span></h3>
                    Account Balance
                    <div class="text-muted text-size-small"><span id="today_balance"></span> Today balance</div>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="panel bg-warning-400">
                <div class="panel-body">
                    <div class="heading-elements">
                        <i class="icon-users4"></i>
                    </div>
                    <h3 class="no-margin"><span id="total_customer"><i class="icon-spinner2 spinner"></i></span></h3>
                    Total Customer
                    <div class="text-muted text-size-small"><span id="new_customer"></span> New Customer</div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <x-pnl>
                <div class="chart has-fixed-height has-minimum-width" style="overflow-x: auto; overflow-y: hidden;" id="pie_stock">
                    <p class="text-center spin" style="line-height: 300px;"><i class="icon-spinner2 icon-2x spinner"></i></p>
                </div>
            </x-pnl>
        </div>
        <div class="col-md-6">
            <x-pnl>
                <div class="chart has-fixed-height has-minimum-width" style="overflow-x: auto; overflow-y: hidden;" id="pie_customer">
                    <p class="text-center spin" style="line-height: 300px;"><i class="icon-spinner2 icon-2x spinner"></i></p>
                </div>
            </x-pnl>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <x-pnlx name="Last 10 Sales">
                <div class="has-fixed-height has-minimum-width" style="overflow: auto;">
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Balance Due</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                @foreach($sales as $row)
                                    <td>
                                        <div class="media-left media-middle">
                                            <a @can('Sales Invoice') href="{{route('sales.show', ['sale' => $row->id])}}" @endcan class="btn {{$colors[mt_rand(0,9)]}} btn-rounded btn-icon btn-xs">
                                                <span class="letter-icon">{{$row->name[0]}}</span>
                                            </a>
                                        </div>

                                        <div class="media-body">
                                            <div class="media-heading">
                                                <a @can('Sales Invoice') href="{{route('sales.show', ['sale' => $row->id])}}" @endcan class="letter-icon-title">{{$row->name}}</a>
                                            </div>

                                            <div class="text-muted text-size-small"><i class="icon-hash text-size-mini position-left"></i>{{$row->code}}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted text-size-small">{{pub_date($row->created_at)}}</span>
                                    </td>
                                    <td>
                                        <h6 class="text-semibold no-margin">{{money_c($row->invoice_sub_total())}}</h6>
                                    </td>
                                    <td>
                                        <p class="text-semibold no-margin">{{money_c($row->invoice_paid())}}</p>
                                    </td>
                                    <td>
                                        <p class="text-semibold no-margin">{{money_c($row->invoice_due())}}</p>
                                    </td>
                                    <td>
                                        <p class="text-semibold no-margin">{{money_c($row->balance_due())}}</p>
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>

                </div>
            </x-pnlx>
        </div>
        <div class="col-md-6">
            <x-pnlx name="Last 10 Purchase">
                <div class="has-fixed-height has-minimum-width" style="overflow: auto;">
                    <table class="table text-nowrap">
                        <thead>
                        <tr>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Balance Due</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @foreach($purchase as $row)
                                <td>
                                    <div class="media-left media-middle">
                                        <a @can('Purchase Invoice') href="{{route('purchase.show', ['purchase' => $row->id])}}" @endcan class="btn {{$colors[mt_rand(0,9)]}} btn-rounded btn-icon btn-xs">
                                            <span class="letter-icon">{{$row->name[0]}}</span>
                                        </a>
                                    </div>

                                    <div class="media-body">
                                        <div class="media-heading">
                                            <a @can('Purchase Invoice') href="{{route('purchase.show', ['purchase' => $row->id])}}" @endcan class="letter-icon-title">{{$row->name}}</a>
                                        </div>

                                        <div class="text-muted text-size-small"><i class="icon-hash text-size-mini position-left"></i>{{$row->code}}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted text-size-small">{{pub_date($row->created_at)}}</span>
                                </td>
                                <td>
                                    <h6 class="text-semibold no-margin">{{money_c($row->invoice_sub_total())}}</h6>
                                </td>
                                <td>
                                    <p class="text-semibold no-margin">{{money_c($row->invoice_paid())}}</p>
                                </td>
                                <td>
                                    <p class="text-semibold no-margin">{{money_c($row->invoice_due())}}</p>
                                </td>
                                <td>
                                    <p class="text-semibold no-margin">{{money_c($row->balance_due())}}</p>
                                </td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </x-pnlx>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <x-pnl name="Last 30 days's Sales & Purchase Graph">
                <div class="chart has-fixed-height" style="overflow-x: auto; overflow-y: hidden;" id="area_zoom">
                    <p class="text-center spin" style="line-height: 300px;"><i class="icon-spinner2 icon-2x spinner"></i></p>
                </div>
            </x-pnl>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <x-pnl name="Last 12 Month's Sales & Purchase Column">
                <div class="chart has-fixed-height" style="overflow-x: auto; overflow-y: hidden;" id="columns_basic">
                    <p class="text-center spin" style="line-height: 300px;"><i class="icon-spinner2 icon-2x spinner"></i></p>
                </div>
            </x-pnl>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript" src="{{asset('public/global_assets/js/plugins/visualization/echarts/echarts.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/chart/chart.js')}}"></script>

    <script type="text/javascript">

        $(function () {

            $.getJSON( "{{route('api.graph')}}", function( data ) {
                var product_names = [];
                var customer_names = [];

                var op_date = [];
                var sales = [];
                var purchase = [];

                var op_month = [];
                var mo_sales = [];
                var mo_purchase = [];

                $.each( data.stock, function( key, val ) {
                    product_names.push(val.name);
                });

                $.each( data.customer, function( key, val ) {
                    customer_names.push(val.name);
                });

                $.each( data.invoice, function( key, val ) {
                    op_date.push(val.date);
                    sales.push(val.sales);
                    purchase.push(val.purchase);
                });


                $.each( data.yearly, function( key, val ) {
                    op_month.push(val.month);
                    mo_sales.push(val.sales);
                    mo_purchase.push(val.purchase);
                });

                $('.spin').hide();

                var pie_stock_element = document.getElementById('pie_stock');
                var pie_stock = echarts.init(pie_stock_element);

                var pie_sales_element = document.getElementById('pie_customer');
                var pie_sales = echarts.init(pie_sales_element);

                var area_zoom_element = document.getElementById('area_zoom');
                var area_zoom = echarts.init(area_zoom_element);

                var columns_basic_element = document.getElementById('columns_basic');
                var columns_basic = echarts.init(columns_basic_element);

                pie_stock.setOption(pie(data.stock, product_names, 'Top 10 products', 'Top product by current stock', 'Stock'));
                pie_sales.setOption(pie(data.customer, customer_names, 'Top 10 Customers', 'Top customer by Sales', 'Sales'));
                area_zoom.setOption(zoom_area(op_date, sales, purchase));
                columns_basic.setOption(column_chart(op_month, mo_sales, mo_purchase));

            });



            $.getJSON( "{{route('api.info')}}", function( data ){
                console.log(data);
                $('#today_sale').html(Number(data.today_sale).toFixed(2));
                $('#today_purchase').html(Number(data.today_purchase).toFixed(2));
                $('#today_expance').html(Number(data.today_expance).toFixed(2));
                $('#stock_value').html(Number(data.stock_value).toFixed(2));
                $('#total_customer').html(data.total_customer);
                $('#ac_balance').html(Number(data.ac_balance).toFixed(2));
                $('#customer_due').html(Number(data.customer_due).toFixed(2));
                $('#supplier_due').html(Number(data.supplier_due).toFixed(2));
                $('#monthly_expance').html(Number(data.monthly_expance).toFixed(2));
                $('#stock_lower').html(data.stock_lower);
                $('#today_balance').html(Number(data.today_balance).toFixed(2));
                $('#new_customer').html(data.new_customer);
            });
        });

    </script>
@endsection