@extends('layouts.master')

@section('title')
    Stock Report
@endsection
@section('content')
    <div class="row">
        <div class="col-md-5">
            <x-rpnl name="Product Stock Report" action="{{route('reports.stock-product')}}">
                <x-dselect class="product_type" name="product_type" label="Product Type" required="" >
                    <option value="">Select Product Type (Optional)</option>
                    <option value="Main">Main</option>
                    <option value="Other">Other</option>
                </x-dselect>
                <x-dselect class="category" name="product_categories_id" label="Product Category" required="required" required="">
                    <option value="">All Category (Optional)</option>
                    @foreach($category as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-dselect>
                <x-dselect class="companies" name="companies_id" label="Product Companies" required="">
                    <option value="">All Company (Optional)</option>
                    @foreach($company as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-dselect>
                <x-dselect class="stock_lower" name="stock_lower" label="Stock Status" required="" >
                    <option value="">Select Stock Status (Optional)</option>
                    <option value="limit">Lower Then Alert Limit</option>
                    <option value="out_of">Only Out of stock</option>
                </x-dselect>
            </x-rpnl>
        </div>

        <div class="col-md-5">
            <x-rpnl name="Product Stock Transaction" action="{{route('reports.stock-transaction')}}">
                <x-dinput class="date_pic" name="date_range" label="Date Range" required="required">
                    <x-slot name="addon"><i class="icon-calendar2"></i></x-slot>
                </x-dinput>
                <x-dselect label="Product" class="products" name="products_id" required="">
                    <option value="">Select Product (Optional)</option>
                    @foreach($table as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-dselect>
            </x-rpnl>
        </div>

    </div>

@endsection

@section('script')
    <script type="text/javascript">

        // if(performance.navigation.type === 2) {//Refresh back btn history
        //     location.reload();
        // }

        $(function () {
            $('.product_type, .category, .brands, .companies, .stock_lower, .products').select2();

            $('.date_pic').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        });


    </script>
@endsection