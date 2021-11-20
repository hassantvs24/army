@extends('layouts.master')

@section('title')
    Purchase Report
@endsection
@section('content')

    <div class="row">

        <div class="col-md-5">
            <x-rpnl name="Purchase Invoice" action="{{route('reports.purchase_invoice')}}">
                <x-dinput class="date_pic" name="date_range" label="Date Range" required="required">
                    <x-slot name="addon"><i class="icon-calendar2"></i></x-slot>
                </x-dinput>
                <x-dselect label="Supplier" class="supplier" name="suppliers_id" required="">
                    <option value="">Select Supplier (Optional)</option>
                    @foreach($supplier as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-dselect>

                <x-check name="due" value="due" label="Due Invoice List" />

            </x-rpnl>
        </div>

        <div class="col-md-5">
            <x-rpnl name="Purchase Invoice Item" action="{{route('reports.purchase_items')}}">
                <x-dinput class="date_pic" name="date_range" label="Date Range" required="required">
                    <x-slot name="addon"><i class="icon-calendar2"></i></x-slot>
                </x-dinput>
                <x-dselect label="Product" class="products" name="products_id" required="">
                    <option value="">Select Product (Optional)</option>
                    @foreach($products as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach
                </x-dselect>
            </x-rpnl>
        </div>

    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $('.products, .supplier').select2();

            $('.date_pic').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        });
    </script>
@endsection